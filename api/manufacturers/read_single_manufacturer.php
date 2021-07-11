<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../database/Database.php';
include_once '../../models/Manufacturers.php';

$database = new Database();
$db = $database->connect();

$manufacturer = new Manufacturers($db);

$manufacturer->id = isset($_GET['id']) ? $_GET['id'] : die();

$manufacturer->read_single();

$arrMan = array(
    'id' => $manufacturer->id,
    'name' => $manufacturer->name,
    'country' => $manufacturer->country
);

print_r(json_encode($arrMan));

?>