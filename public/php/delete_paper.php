<?php
    /*
     * 削除用
    */
    // セッションで削除できる権限を持っているのかを確認
    session_start();
    
    require_once "../../src/SqlHelper.php";
    use App\SqlHelper;

    if (!isset($_SESSION["user_id"])){
        header("Location: login.php");
        exit();
    }

    if($_SESSION["user_id"]!=$_GET["user_id"] && $_SESSION["permission"]!="admin"){
        header("Location: login.php");
        exit();
    }
    
    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();

    $id = [":id"=>$_GET["paper_id"]];

    var_dump($_GET);

    if($_GET["confirmed"] === "true"){
        $sql = "UPDATE papers SET view_flag = false WHERE id = :id";
        $result = $sqlHelper->executeQuery($sql, "UPDATE", $id);

        echo "削除しました";
        header("Location: search.php");
        exit();
    } else {
        // echo "falseなことあるんですね";
        $sql = "UPDATE papers SET view_flag = true WHERE id = :id";
        $result = $sqlHelper->executeQuery($sql, "UPDATE", $id);
        
        echo "更新しました";
        header("Location: {$_GET["homepage"]}");
        exit();
    }
?>