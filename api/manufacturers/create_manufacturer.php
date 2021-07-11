<?php
session_start();

if($_SESSION['username'] != 'admin') {
    header('location: ../../forms/index.php');
}

include_once '../../database/Database.php';
include_once '../../models/Manufacturers.php';

$database = new Database();
$db = $database->connect();

$manufacturer = new Manufacturers($db);

$name = $_POST['name'];
$country = $_POST['country'];


if($name == "" || $country == "") {
    echo json_encode(
        array('message' => 'Please Enter Credentials')
    );
    die();
}

$manufacturer->name = $name;
$manufacturer->country = $country;

if($manufacturer->create()) {
    echo json_encode(
        array('message' => 'Category Created')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
}

?>