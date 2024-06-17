<?php
    // namespaceの指定．
    // ここで記述したクラスを他のソースコードで呼び出す際に必要
    namespace App;

    require_once "CounterCrossSite.php";

    // 他の名前空間から呼び出すため宣言
    use \PDO;
    use \PDOException;
    use App\CounterCrossSite;

    /* 各ページでデータベース処理を毎回書くのが大変なので，クラスを作成
     * 
     * 
    */
    class SqlHelper
    {
        // サーバーの場所を格納
        // xamppなどでローカルサーバー使う場合はlocalhostでOK
        protected $servername;
        // データベースサーバーのログインで用いるユーザー名
        protected $username;
        // パスワード
        // セキュリティ面を考慮するなら暗号化した方がいい（出来ればで）
        protected $password;
        // データベース名
        protected $database;
        // 文字コード
        protected $charset;
        // データベースの接続するために必要な情報を表す
        protected $dsn;
        // データベースと接続を管理
        protected $pdo;
        // クロスサイトスクリプティング対策用
        protected $CCS;

        /*
         * コンストラクタ
        */
        public function __construct()
        {
            $this->servername = "localhost";
            $this->username = "testuser";
            $this->password = "testpass";
            $this->database = "paper_reader";
            $this->charset = "utf8";
            $this->dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->database . ";charset=" . $this->charset;
            $this->CCS = new CounterCrossSite();
        }

        /*
         * データベースと接続する
         * @return [bool] 接続ができたらtrue，失敗したらfalseが帰ってくる
        */
        public function connect(): bool
        {
            try{
                // インスタンス生成
                // 名前空間が違うので，クラス名の前に\を入れて直接クラスを指定する必要がある
                $this->pdo = new PDO($this->dsn, $this->username, $this->password);
                // エラーモードを例外モードに設定
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // デバッグ用
                // echo "データベースの接続に成功しました";

                return true;
            } catch (PDOException $e){
                // 
                echo "データベースへの接続に失敗しました:" . $e->getMessage();
                return false;
            }
        }

        /*
         * データベースとの接続解除
         * @return [bool] 正しく処理が終了すればtrue，失敗すればfalse
         * 
         * PDOはスクリプトが終了すると自働的にオブジェクトが破棄され，接続も解除される．
         * そのため本来は必要ないが，他の言語だと必要な時もあるため一応記述
        */
        public function disconnect(): bool
        {
            // データベースと接続してない場合
            if($this->pdo===null){
                echo "not connection";
                return false;
            }
            // 接続している場合，解除処理
            try{
                $this->pdo = null;
                return true;
            } catch (PDOException $e){
                echo "接続の解除に失敗しました:" . $e->getMessage();
                return false;
            }
        }

        /*
         * 指定したクエリの実行
         * @param $query [string]：クエリ（sql文）をプレースホルダーで受け取る
         * @param $queryType [string]：クエリの種類の指定
         * @param $placeholder [string]：プレースホルダーで入力する値を連想配列で受け取る
         * @return return [mixed]
         * select文の場合は連想配列
         * それ以外の実行結果の場合は更新された行数
         * エラーがあった場合はnull
        */
        public function executeQuery(string $query, string $queryType, ?array $placeholders = null): mixed
        {
            // 空だった場合
            if(!isset($query) || !isset($queryType)){
                echo "空の要素が存在します";
                return false;
            }
            try{
                $stmt = $this->pdo->prepare($query);
                if($placeholders!=null){
                    // クロスサイトスクリプティング
                    $resultPlaceHolders = $this->CCS->replace($placeholders);
                    foreach($resultPlaceHolders as $key => $value){
                        $stmt->bindValue($key, $value);
                    }
                }

                $result = $stmt->execute();
                if(strtolower($queryType)===strtolower("select")){
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else if(strtolower($queryType)===strtolower("show")){
                    $result = $stmt->fetchAll(PDO::FETCH_NUM);
                }
                return $result;
            } catch(PDOException $e){
                echo "クエリの実行に失敗しました" . $e->getMessage();
                return $e;
            }
        }

        /*
         * ログイン処理
         * @param $username[string] : ユーザー名
         * @param $password[string] : パスワード
         * @return
         * $[array] : [
         *      success[bool] : 結果をboolでtrue以外は基本エラー
         *      message[string] : メッセージ．そのまま出力して
         *      user[array] : ログインが成功している場合，連想配列で対応するusersの一行が入ってる
         * ]
        */
        public function login(string $username, string $password): mixed
        {
            // 空だった場合の想定
            if(!isset($username) || !isset($password)){
                echo "空の要素があります";
                return false;
            }

            // ここでクロスサイトスクリプティング（usernameはexecuteQueryでされるからしなくてもいいかも）
            $placeholders = [
                'username' => $username,
                'password' => $password
            ];

            $placeholders = $this->CCS->replace($placeholders);

            $sql = "SELECT * FROM users WHERE username=:username";
            $uPlaceholder = array_slice($placeholders,0,1);
            $result = $this->executeQuery($sql, "SELECT", $uPlaceholder);

            if(!empty($result)){
                if (password_verify($password, $result[0]['password'])) {
                    return [
                        'success' => true,
                        'message' => "ログインに成功しました。",
                        'user' => $result[0]
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => "パスワードが正しくありません。"
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => "ユーザー名が存在しません。"
                ];
            }
        }
    }
?>