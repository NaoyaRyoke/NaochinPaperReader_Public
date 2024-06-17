<?php
    /*
     * 論文を投稿する用のページ
    */
    session_start();

    require_once "../../src/SqlHelper.php";
    use App\SqlHelper;

    // ログインしていない状態で投稿されても困るので
    if(!isset($_SESSION["user_id"])){
        header("Location: login.php");
        exit();
    }

    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();

    // この中にいい感じに処理を書く
    if(isset($_POST["title"])){

    }

    $content = <<< HTML
        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>論文投稿</title>
            <link rel="stylesheet" href="../css/normalize.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/add_paper.css">
        </head>
        <body>
            <header class="header">
                <h1 class="english-text"><a href="title.php">PaperChat</a></h1>
            </header>
            <main class="english-text">
                <form action="add_paper.php" method="POST">
                    <section class="add-form">
                        <section>
                            <p>Title</p>
                            <input type="text" name="title" class="title-text" required>
                        </section>
                        <section>
                            <table id="authers">
                                <thead>
                                    <tr>
                                        <td><p>著者 <button id="add_authers" type="button">追加</button></p></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="authers[]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                        <section>
                            <p>Abstruct</p>
                            <textarea name="abstract" rows="15" cols="100"></textarea>
                        </section>
                        <section>
                            <p>Content</p>
                            <textarea name="content" rows="50" cols="100"></textarea>
                        </section>
                    </section>
                    <section>
                        <input type="submit" value="submit">
                    </section>
                </form>
            </main>
            <footer></footer>
        </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/button_function.js"></script>
        </html>
    HTML;
    echo $content;
?>