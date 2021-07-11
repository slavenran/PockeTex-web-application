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
include_once '../../models/Phones.php';

$id = $_GET['id'];

$database = new Database();
$db = $database->connect();

$phone = new Phones($db);

$phone->id = $id;

if($phone->delete()) {
    echo json_encode(
        array('meessage' => 'Phone Deleted')
    );
    header('location: ../../admin/phones.php');
} else {
    echo json_encode(
        array('meessage' => 'Phone Not Deleted')
    );
    header('location: ../../admin/phones.php');
}

