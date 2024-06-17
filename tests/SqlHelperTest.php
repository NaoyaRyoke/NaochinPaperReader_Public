<?php
    /// disconnectは必要ないので省略
    require_once "../src/SqlHelper.php";
    use App\SqlHelper;
    
    // connect
    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();

    // executeQuery select
    $query = "SELECT * from Users";
    $result = $sqlHelper->executeQuery($query,"select");
    foreach($result as $rows){
        foreach($rows as $key=>$value){
            echo $value . " ";
        }
        echo "<br>";
    }
    // executeQuery insert
    // executeQuery update
    // executeQuery delete(ほとんど使わないのでしなくてもいい)

    // login
    // true
    $username = "naochin";
    $password = "1234";
    $result = $sqlHelper->login($username, $password);
    if($result['success']){
        echo "ログイン成功";
    } else{
        echo "ログイン失敗...<br>".$result['message'];
    }
    echo "<br>";
    // false (not pass)
    $username = "naochin";
    $password = "12341234";
    $result = $sqlHelper->login($username, $password);
    if($result["success"]){
        echo "ログイン成功";
    } else{
        echo "ログイン失敗...<br>".$result['message'];
    }
    echo "<br>";
    // false (not user)
    $username = "nao";
    $password = "1234";
    $result = $sqlHelper->login($username, $password);
    if($result["success"]){
        echo "ログイン成功";
    } else{
        echo "ログイン失敗...<br>".$result['message'];
    }
    echo "<br>";
    // 他にも必要なケースはあるけど最低限これで
?>