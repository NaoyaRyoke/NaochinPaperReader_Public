<?php
    require_once "../src/CounterCrossSite.php";
    use App\CounterCrossSite;

    $CCS = new CounterCrossSite();

    $message['testA'] = "hello";
    foreach($message as $key => $value){
        echo $key . "=>" . $value . ",";
    }
    echo "<br>";

    $message = $CCS->replace($message);
    foreach($message as $key => $value){
        echo $key . "=>" . $value . ",";
    }
    echo "<br>";

    $message['testA'] = "<br>";
    $message['testB'] = "<script>alert(\"ngo\")</script>";
    foreach($message as $key => $value){
        echo $key . "=>" . $value . ",";
    }
    echo "<br>";


    $message = $CCS->replace($message);
    foreach($message as $key => $value){
        echo $key . "=>" . $value . ",";
    }
    echo "<br>";


?>