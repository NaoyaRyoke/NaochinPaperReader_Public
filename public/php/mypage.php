<?php
    session_start();

    require_once "../../src/SqlHelper.php";

    use App\SqlHelper;

    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();

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

    // ユーザー情報の取得
    $placeHolder = [":user_id" => $_GET["id"]];
    $sql = "SELECT * FROM users WHERE id = :user_id";
    $user = $sqlHelper->executeQuery($sql, "SELECT", $placeHolder);

    // 自著論文の取得
    $placeHolder = [":user_id" => $_GET["id"]];
    $sql = "SELECT * FROM papers WHERE user_id = :user_id";
    $papers = $sqlHelper->executeQuery($sql, "SELECT", $placeHolder);
    
    $searchElements = "";
    foreach($papers as $value){
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
            <title>{$user[0]["username"]}</title>
            <link rel="stylesheet" href="../css/normalize.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/search.css">
            <link rel="stylesheet" href="../css/mypage.css">
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

            <main class="english-text">
                <section>
                    <h2 class="username">{$user[0]["username"]}</h2>
                </section>
                <section class="other-info">
                    <p>E-mail：{$user[0]["email"]}</p>
                    <p>affiliation：{$user[0]["affiliation"]}</p>
                </section>
                <section>
                    {$searchElements}
                </section>
            </main>
            <footer></footer>
        </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/button_function.js"></script>
        </html>
    HTML;
    echo $content;
?>