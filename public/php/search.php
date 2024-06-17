<?php
    /*
     * 検索画面
     * 
    */
    session_start();

    // // ログイン情報なしで入った場合，ログイン画面に飛ばされる
    // if(!isset($_SESSION["user_id"])) {
    //     header("Location: login.php");
    //     exit();
    // }

    require_once "../../src/SqlHelper.php";
    
    use App\SqlHelper;

    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();

    $errorMessage = "";
    $inputText = "";
    $result = null;

    // // ハンバーガーメニュー
    // $hambugerList = "<li class=\"nav_item\"><a href=\"add_paper.php\">論文投稿</a></li>";
    // if($_SESSION["permission"]!='viewer'){
    //     $hambugerList.="<li class=\"nav_item\"><a href=\"administrator.php\">管理者画面</a></li>";
    // }
    // $hambugerList.="<li class=\"nav_item\"><a href=\"logout.php\">ログアウト</a></li>";
    // ログイン情報によってハンバーガーメニューを切り替える

    $hambugerList = "";
    if(!isset($_SESSION["user_id"])){
        $hambugerList .= "<li class=\"nav_item\"><a href=\"login.php\">ログイン</a></li>";
    } else {
        $hambugerList .= "<li class=\"nav_item\"><a href=\"mypage.php?id={$_SESSION["user_id"]}\">マイページ</a></li>";
        $hambugerList .= "<li class=\"nav_item\"><a href=\"add_paper.php\">論文投稿</a></li>";
        if($_SESSION["permission"]!='viewer'){
            $hambugerList.="<li class=\"nav_item\"><a href=\"administrator.php\">管理者画面</a></li>";
        }
        $hambugerList.="<li class=\"nav_item\"><a href=\"logout.php\">ログアウト</a></li>";
    }
    
    // 検索
    if(empty($_GET["keyword"])) {
        $sql = "SELECT * FROM papers;";
        $result = $sqlHelper->executeQuery($sql, "SELECT");
        $inputText = "<input type='text' class=\"keyword\" name=\"keyword\">";
    } else {
        // 検索用テーブルから
        // in句にプレースホルダー入れるために，先に作ってから
        // プレースホルダーでLIKE句を使う場合，先に%%では挟んだものを使う必要がある
        // LIKEとinが一緒に使えないバグが発覚したので，orでつなげていきます．
        $keyword = [":keyword" => "%" . $_GET["keyword"] . "%"];
        $sql = "SELECT * FROM search_term_translator WHERE abbreviation LIKE :keyword;";
        $result = $sqlHelper->executeQuery($sql, "SELECT", $keyword);

        $sql = "SELECT * FROM papers WHERE title LIKE :keyword";
        // ここでsql生成
        for($i = 0; $i < count($result); $i++){
            $holderName = ":".$i;
            // プレースホルダー用連想配列の追加
            $keyword[$holderName] = "%".$result[0]["expansion"]."%";
            // sql文の追加（OR）
            $sql .= " OR title LIKE ".$holderName;
        }

        $result = $sqlHelper->executeQuery($sql, "SELECT", $keyword);
        if($result != null) {

        } else {
            $errorMessage="該当結果がありません";
        }
        $inputText = "<input type='text' class=\"keyword\" name=\"keyword\" value={$_GET["keyword"]}>";
    }

    $searchElements = "";
    foreach($result as $value) {
        if($value["view_flag"]!=0){

            // ここでautherとってきて並べる
            $sql = "SELECT * FROM paper_authers WHERE paper_id = {$value["id"]}";
            $autherResult = $sqlHelper->executeQuery($sql, "SELECT");
            
            $searchElements.="<section class=\"paper-content\">";
            $searchElements.= "<li>";
            $searchElements.= "<a href=\"content.php?id={$value["id"]}\">";
            $searchElements.= htmlspecialchars("{$value["title"]}");
            $searchElements.="<br>";
            $searchElements.="<section class=\"auther-list\">";
            foreach($autherResult as $autherValue) {
                if($autherValue["user_id"]!=-1) {
                    $searchElements.="<p class=\"auther-name\">{$autherValue["auther_name"]}</p>";
                } else {
                    $searchElements.="<p class=\"auther-name\">{$autherValue["auther_name"]}</p>";
                }
            }
            $searchElements.="</section>";
            $searchElements.="<section>";
            if(strlen($value["abstract"])>=1000){
                $searchElements.="<p class=\"abstract-name\">".substr($value["abstract"], 0, 1000)."</p>";
            } else {
                $searchElements.="<p class=\"abstract-name\">".$value["abstract"]."</p>";
            }
            $searchElements.="</section>";
            $searchElements.= "</a>";
            $searchElements.= "</li>";
            $searchElements.="</section>";
        }
    }

    $content = <<< HTML
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>論文検索</title>
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/search.css">
    </head>
    <body>
        <header class="header">
            <section>
                <h1 class="english-text"><a href="title.php" class="logo">PaperChat</a></h1>
            </section>
            <!-- ハンバーガーメニューやつ -->
            <div class="nav">
                <input id="drawer_input" class="drawer_hidden" type="checkbox">
                <label for="drawer_input" class="drawer_open"><span></span></label>
                <nav class="nav_content">
                    <ul class="nav_list">
                        {$hambugerList}
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <section class="english-text">
                <form action="search.php" method="GET">
                    <section class="search-form">
                        {$inputText}
                        <input type="submit" value="Search">
                    </section> 
                </form>
            </section>
            <section class="search-list">
                {$searchElements}
            </section>
            {$errorMessage}
        </main>
        <footer></footer>
    </body>
    </html>
    HTML;
    echo $content;
?>