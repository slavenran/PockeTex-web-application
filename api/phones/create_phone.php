<?php
session_start();

if($_SESSION['username'] != 'admin') {
    header('location: ../../forms/index.php');
}

include_once '../../database/Database.php';
include_once '../../models/Phones.php';

$database = new Database();
$db = $database->connect();

$phone = new Phones($db);

$model = $_POST['model'];
$year = $_POST['year'];
$manuId = $_POST['manuId'];


if($model == "" || $year == "") {
    echo json_encode(
        array('message' => 'Please Enter Credentials')
    );
    die();
}

$phone->model = $model;
$phone->year = $year;
$phone->manufacturer_id = $manuId;

if($phone->create()) {
    echo json_encode(
        array('message' => 'Category Created')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
}

?>