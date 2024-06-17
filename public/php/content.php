<?php
    /*
     * 論文内容の表示
    */
    session_start();

    // 無いとは思うけど，論文idがない場合に検索ページに飛ばす
    if(!isset($_GET["id"])) {
        echo "<script>history.back()</script>";
    }

    require_once "../../src/SqlHelper.php";

    use App\SqlHelper;
    
    $sqlHelper = new SqlHelper();

    $sqlHelper->connect();

    // 論文の基本情報の取得
    $placeHolder = [":paper_id" => $_GET["id"]];
    $sql = "SELECT * FROM papers WHERE id = :paper_id";
    $paper = $sqlHelper->executeQuery($sql, "SELECT", $placeHolder);
    
    $hambugerList = "";
    if(!isset($_SESSION["user_id"])){
        $hambugerList .= "<li class=\"nav_item\"><a href=\"login.php\">ログイン</a></li>";
    } else {
        $hambugerList .= "<li class=\"nav_item\"><a href=\"mypage.php?id={$_SESSION["user_id"]}\">マイページ</a></li>";
        $hambugerList .= "<li class=\"nav_item\"><a href=\"add_paper.php\">論文投稿</a></li>";
        if($_SESSION["permission"]!="viewer"){
            $hambugerList.="<li class=\"nav_item\"><a href=\"administrator.php\">管理者画面</a></li>";
        }
        if($_SESSION["permission"]!="viewer" || $_SESSION["user_id"] == $paper[0]["user_id"]){
            $hambugerList.="<li class=\"nav_item\"><a href=\"javascript:confirmAndProcess();\">論文の削除</a></li>";
        }
        $hambugerList.="<li class=\"nav_item\"><a href=\"logout.php\">ログアウト</a></li>";
    }

    $inputInlineForm="";
    if(isset($_SESSION["user_id"])){
        $inputInlineForm.="<p class=\"my_buttion\">インラインコメント入力 <a href=\"#\" id=\"input_inline_comment\"><span>投稿</span></a></p>";
        $inputInlineForm.="<textarea name=\"inline_comment\" id=\"inline_comment\" rows=\"3\" cols=\"50\"></textarea>";
    }

    $mainContent = "<p id='mainContent'>".nl2br(htmlspecialchars($paper[0]["content"]))."</p>";
    $abstract = "<p id='abstract'>".nl2br(htmlspecialchars($paper[0]["abstract"]))."</p>";
    $tempAbstract = "<p id='tempAbstract'>".nl2br(htmlspecialchars($paper[0]["abstract"]))."</p>";

    $placeHolder = [":paper_id" => $_GET["id"]];
    $sql = "SELECT * FROM paper_authers WHERE paper_id = :paper_id";
    $authers = $sqlHelper->executeQuery($sql, "SELECT", $placeHolder);
    $autherList = "";
    foreach($authers as $key=>$value){
        if($value["user_id"]!=-1){
            $autherList.="<a href=\"mypage.php?id={$value["user_id"]}\">{$value["auther_name"]}</a> ";
        } else {
            $autherList.="{$value["auther_name"]} ";
        }
    }

    // インラインコメントの取得
    $placeHolder = [":paper_id" => $_GET["id"]];
    $sql = "SELECT paper_comments.*, username FROM paper_comments inner join users on paper_comments.user_id = users.id WHERE paper_id = :paper_id AND parent_id = -1";
    $inline = $sqlHelper->executeQuery($sql, "SELECT", $placeHolder);
    $inlineJson = json_encode($inline);

    // HTML
    $content = <<< HTML
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$paper[0]["title"]}</title>
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/content.css">
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
            <section class="container">
                <section class="content">
                    <h2>{$paper[0]["title"]}</h2>
                    {$mainContent}
                </section>
                <section class="abstract">
                    <section>
                        <p>著者：{$autherList}</p>
                    </section>
                    <section>
                        <p>概要</p>
                        {$abstract}
                    </section>
                    <section>
                        <p>インラインコメント表示 <a href="#" id="delete_inline_comment">非表示</a></p>
                        <section id="reply_comment">
                        </section>
                        {$inputInlineForm}
                    </section>
                    <section>
                        <p>ユーザーコメント<button id="write_user_memo" type="button">編集</button><button id="save_user_memo" type="button">保存</button></p>
                        <textarea name="user_memo" id="user_memo" rows="10" cols="50" readonly></textarea>
                    </section>
                </section>
            </section>
        </main>
        <footer></footer>
        <script>
            var comments = {$inlineJson};
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/inline_function.js"></script>
        <script src="../js/button_function.js"></script>
        <script>
            function confirmAndProcess(){
                var result = confirm("本当に削除しますか");
                if (result){
                    window.location.href = "delete_paper.php?confirmed=true&paper_id={$_GET["id"]}&user_id={$paper[0]["user_id"]}";
                }
            }
        </script>
        
    </body>
    </html>
    HTML;
    echo $content;
?>