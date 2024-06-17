<?php
    /*
     * 管理者画面
     * 情報出力
     * ユーザーの権限変更
    */
    session_start();
    // adminじゃなかったり，session情報がなかったらログイン場所に戻す

    if(!isset($_SESSION["user_id"])){
        header("Location: login.php");
        exit();
    }

    if($_SESSION["permission"]!="admin"){
        echo "<script>history.back()</script>";
    }

    require_once "../../src/SqlHelper.php";
    use App\SqlHelper;

    $errorMessage = "";

    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();
    
    // ハンバーガーメニュー
    $hambugerList = "<li class=\"nav_item\"><a href=\"add_paper.php\">論文投稿</a></li>";
    $hambugerList .= "<li class=\"nav_item\"><a href=\"mypage.php?id={$_SESSION["user_id"]}\">マイページ</a></li>";
    if($_SESSION["permission"]!='viewer'){
        $hambugerList.="<li class=\"nav_item\"><a href=\"administrator.php\">管理者画面</a></li>";
    }
    $hambugerList.="<li class=\"nav_item\"><a href=\"logout.php\">ログアウト</a></li>";

    // 使用テータベースに存在するデータベースを全て表示する
    $sql = "show tables";
    $result = $sqlHelper->executeQuery($sql, "show");
    $pullDownMenu = "<form action=\"administrator.php\" id=\"pull_down_form\" method=\"POST\">";
    $pullDownMenu .= "<select id=\"table_name\" name=\"table_name\">";
    $pullDownMenu .= "<option>---</option>";
    foreach($result as $value){
        // echo $value[0] . "<br>";
        if(isset($_POST["table_name"]) && $value[0]==$_POST["table_name"]) $pullDownMenu.="<option value=\"$value[0]\" selected>".$value[0]."</option>";
        else $pullDownMenu .= "<option value=\"$value[0]\">".$value[0]."</option>";
    }
    $pullDownMenu .= "</select></form>";

    $showTable = "";
    if(isset($_POST["table_name"]) && $_POST["table_name"]!="---"){
        // プレースホルダーとしてテーブル名を使うことができないらしい
        $sql = "SELECT * FROM {$_POST["table_name"]};";
        $result = $sqlHelper->executeQuery($sql,"SELECT");
        $showTable.="<h2>".$_POST["table_name"]."</h2><table>";
        // 文字列連結してhtmlで出力するように
        foreach($result as $temp => $rows){
            $showTable.="<tr>";
            foreach($rows as $key => $value){
                if(strlen($value)>=50){
                    $showTable .= "<td>".(substr($value, 0, 50)."</td>");
                } else {
                    $showTable .= "<td>".($value ."</td>");
                }
            }
            if($_POST["table_name"] == "papers"){
                $showTable .= "<td><button onclick=\"confirmAndProcess({$rows["id"]}, {$rows["user_id"]})\">論文の復活</button></td>";   
            }
            $showTable .= "</tr>";
        } $showTable .= "</table>";
    }
    
    $content = <<< HTML
        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>管理者画面</title>
            <link rel="stylesheet" href="../css/normalize.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/content.css">
        </head>
        <body>
            <header class="header">
                <section>
                    <h1><a href="search.php">PaperChat</a></h1>
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
                <section>
                    {$pullDownMenu}
                    <a href="#" onclick="history.back(); return false;">前のページに戻る</a>
                    {$showTable}
                </section>
            </main>
            <footer></footer>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script>
                $(function(){
                    $("#table_name").change(function(){
                        $("#pull_down_form").submit();
                    });
                });
                function confirmAndProcess(paper_id, user_id){
                    var result = confirm("復活の論文");
                    if (result){
                        window.location.href = "delete_paper.php?confirmed=false&paper_id="+paper_id+"&user_id="+user_id+"&homepage=administrator.php";
                    }  
                }
            </script>
        </body>
        </html>
    HTML;
    echo $content;
?>