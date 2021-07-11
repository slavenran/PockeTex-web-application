<?php
session_start();

if($_SESSION['username'] != 'admin') {
    header('location: ../../forms/index.php');
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Method, Authorization, X-Requested-With');

include_once '../../database/Database.php';
include_once '../../models/Comments.php';

$id = $_GET['id'];

$database = new Database();
$db = $database->connect();

$comment = new Comments($db);

$comment->id = $id;

if($comment->delete()) {
    echo json_encode(
        array('meessage' => 'Category Deleted')
    );
    header('location: ../../admin/comments.php');
} else {
    echo json_encode(
        array('meessage' => 'Category Not Deleted')
    );
    header('location: ../../admin/comments.php');
}

?>