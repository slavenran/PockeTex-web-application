<?php

include_once '../../database/Database.php';
include_once '../../models/Comments.php';

$database = new Database();
$db = $database->connect();

$commentModel = new Comments($db);

$comment = $_POST['comment'];
$usernameSession = $_POST['username'];

$sqlUserId = "select * from users where username like '" . $usernameSession . "'";
$username = $db->prepare($sqlUserId);
$username->execute();
$userIdList = $username->fetch(PDO::FETCH_ASSOC);
$userId = $userIdList['id'];

$commentModel->text = $comment;
$commentModel->users_id = $userId;

if($commentModel->create()) {
    echo json_encode(
        array('message' => 'Comment Created')
    );
} else {
    echo json_encode(
        array('message' => 'Comment Not Created')
    );
}

?>