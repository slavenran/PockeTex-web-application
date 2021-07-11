<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../../database/Database.php';
include_once '../../models/Comments.php';

$database = new Database();
$db = $database->connect();

$comments = new Comments($db);

$result = $comments->read();
$num = $result->rowCount();
if ($num > 0) {
    $arrayCom = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $arrayItem = array(
            'id' => $row['id'],
            'text' => $row['text'],
            'users_id' => $row['users_id'],
            'username' => $row['username'],
            'imageurl' => $row['imageurl']
//            'session_username' => $_SESSION['username']
        );
        array_push($arrayCom, $arrayItem);
    }
    echo json_encode($arrayCom);
}

?>