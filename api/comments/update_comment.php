<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../database/Database.php';
include_once '../../models/Comments.php';

$database = new Database();
$db = $database->connect();

$comment = new Comments($db);

$comment->text = $_POST['comment'];
$comment->id = $_POST['id'];

if($comment->update()) {
    echo json_encode(
        array('message' => 'Comment Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Comment Not Updated')
    );
}

?>