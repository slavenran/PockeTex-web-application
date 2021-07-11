<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../database/Database.php';
include_once '../../models/Manufacturers.php';

$database = new Database();
$db = $database->connect();

$manufacturer = new Manufacturers($db);

$result = $manufacturer->read();
$num = $result->rowCount();
if($num > 0) {
    $arrayMan = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $arrayItem = array(
            'id' => $row['id'],
            'name'       => $row['name'],
            'country' => $row['country']
        );
        array_push($arrayMan, $arrayItem);
    }
    echo json_encode($arrayMan);
}

?>