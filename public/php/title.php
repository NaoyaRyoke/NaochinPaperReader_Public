<?php
    /*
     * タイトル画面
    */
    session_start();

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

    $content = <<< HTML
        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>PaperChat</title>
            <link rel="stylesheet" href="../css/normalize.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/title.css">
        </head>
        <body>
            <header class="header">
                <section>
                    <h1 class="english-text"><a href="title.php" class="logo">PaperChat</a></h1>
                </section>
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
            <main class="english-text">
                <form action="search.php" method="GET">
                <section class="search-form">
                    <p><label for="paper-title">Welcome to Paper Chat</label></p>
                    <section class="form-submit">
                        <input type='text' class="keyword" name="keyword">
                        <input type="submit" value="Search">
                    </section>
                </section> 
            </form>
            </main>
            <footer></footer>
        </body>
        </html>
    HTML;
    echo $content;
?>