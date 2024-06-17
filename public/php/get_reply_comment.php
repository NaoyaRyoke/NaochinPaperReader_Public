<?php
    session_start();

    require_once "../../src/SqlHelper.php";
    use App\SqlHelper;

    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();

    $paper_id = $_POST["paper_id"];
    $parent_id = $_POST["parent_id"];

    $placeHolder = [
        ":paper_id" => $paper_id,
        ":parent_id" => $parent_id
    ];
    $sql = "SELECT paper_comments.*, username FROM paper_comments inner join users on paper_comments.user_id = users.id WHERE paper_id = :paper_id AND parent_id = :parent_id";
    $response = $sqlHelper->executeQuery($sql, "SELECT", $placeHolder);

    echo json_encode($response);
?>
