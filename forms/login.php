<?php

session_start();
//header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');
//header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../database/Database.php';
$database = new Database();
$db = $database->connect();

$error = false;
$username = htmlspecialchars(trim($_POST['username']));
$password = htmlspecialchars(trim($_POST['password']));

if (empty($username)) {
    $error = true;
    echo "Enter your username";
    die();
}

if (empty($password)) {
    $error = true;
    echo "Enter your password";
    die();
}

//$password = md5($password);

if (!$error) {
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($count == 1 && $row['password'] == $password) {
        $_SESSION['username'] = $row['username'];
//        echo json_encode("Mjau");
        echo "Success!";
    } else {
        echo "Check your username and/or password";
    }
}