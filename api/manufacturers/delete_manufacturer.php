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
include_once '../../models/Manufacturers.php';

$id = $_GET['id'];

$database = new Database();
$db = $database->connect();

$manufacturer = new Manufacturers($db);

$manufacturer->id = $id;

if($manufacturer->delete()) {
    echo json_encode(
        array('meessage' => 'Manufacturer Deleted')
    );
    header('location: ../../admin/manufacturers.php');
} else {
    echo json_encode(
        array('meessage' => 'Manufactirer Not Deleted')
    );
    header('location: ../../admin/manufacturers.php');
}

