<?php
    session_start();

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    require_once "../../src/SqlHelper.php";
    use App\SqlHelper;

    $sqlHelper = new SqlHelper();
    $sqlHelper->connect();

    $paper_id = $_POST['paper_id'];
    $selected_text = $_POST['selected_text'];
    $comment = $_POST['comment'];
    $anchor_node = $_POST['anchor_node'];
    $anchor_offset = $_POST['anchor_offset'];
    $focus_node = $_POST['focus_node'];
    $focus_offset = $_POST['focus_offset'];
    $user_id = $_SESSION['user_id'];
    $parent_id = $_POST['parent_id'];

    $placeHolder = [
        ":paper_id" => $paper_id,
        ":user_id" => $user_id,
        ":parent_id" => $parent_id,
        ":comment" => $comment,
        ":anchor_node" => $anchor_node,
        ":anchor_offset" => $anchor_offset,
        ":focus_node" => $focus_node,
        ":focus_offset" => $focus_offset
    ];
    $sql = "INSERT INTO paper_comments (paper_id, user_id, parent_id, comment, anchor_node, anchor_offset, focus_node, focus_offset) 
            VALUES (:paper_id, :user_id, :parent_id, :comment, :anchor_node, :anchor_offset, :focus_node, :focus_offset)";
    $sqlHelper->executeQuery($sql, "INSERT", $placeHolder);

    $response = ["comment" => $comment];
    echo json_encode($response);
?>
