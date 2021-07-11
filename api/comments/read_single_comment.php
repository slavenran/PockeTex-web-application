<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../database/Database.php';
include_once '../../models/Comments.php';

$database = new Database();
$db = $database->connect();

$comment = new Comments($db);

$comment->id = isset($_GET['id']) ? $_GET['id'] : die();

$comment->read_single();

$arrMan = array(
    'id' => $comment->id,
    'text' => $comment->text
);

print_r(json_encode($arrMan));

?>