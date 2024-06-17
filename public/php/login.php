<?php
    /* 
     * ログイン画面
    */
    session_start();
    
    // データベース用クラスの呼び出し準備
    require_once "../../src/SqlHelper.php";
    use App\SqlHelper;

    $errorMessage = "";

    // ログインリクエストを受け取った処理
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username=$_POST['username'];
        $password=$_POST['password'];

        $sqlHelper = new SqlHelper();
        $sqlHelper->connect();
        $result = $sqlHelper->login($username, $password);

        if($result['success']){
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['username'] = $result['user']['username'];
            $_SESSION['permission'] = $result['user']['permission'];
            header('Location: title.php');
            exit();
        } else{
            $errorMessage = $result['message'];
        }
    }

    // いっぱい表示
    $content = <<< HTML
        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width-device, initial-scale=1.0">
            <title>ログイン</title>
            <link rel="stylesheet" href="../css/normalize.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/login.css">
        </head>
        <body>
            <header class="header">
                <h1 class="english-text"><a href="title.php" class="logo">PaperChat</a></h1>
            </header>
            
            <main class="english-text">
                <section class="login-form">
                    <p>Welcome to Paper Chat</p>
                    <form action="login.php" method="POST">
                        <section>
                            <p>username</p>
                            <input type="text" id="username" name="username" required>
                        </section>
                        <section>
                            <p>password</p>
                            <input type="password" id="password" name="password" required>
                        </section>
                        <input type="submit" value="Login">
                    </form>
                    <p>{$errorMessage}</p>
                </section>
            </main>
            
            <footer>   
            </footer>
        </body>
        </html>
    HTML;
    echo $content;   
?>