
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../database/Database.php';
include_once '../../models/Phones.php';

$database = new Database();
$db = $database->connect();

$phone = new Phones($db);

if(!isset($_POST['id'])) {
    $sql2 = "SELECT m.name, p.model, p.year, p.id FROM phones p, manufacturers m WHERE m.id = p.manufacturer_id";
    $stmt = $db->prepare($sql2);
    $stmt->execute();

    $output = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $outputItem = array(
            'name' => $row['name'],
            'model' => $row['model'],
            'year' => $row['year'],
            'id' => $row['id']
        );
        array_push($output, $outputItem);
    }

    echo json_encode($output);
//    echo json_encode(array('message' => "Nothing"));
    die();
}

$id = $_POST['id'];

if($id == "ori"){
    $sql2 = "SELECT m.name, p.model, p.year, p.id FROM phones p, manufacturers m WHERE m.id = p.manufacturer_id";
    $stmt = $db->prepare($sql2);
    $stmt->execute();

    $output = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $outputItem = array(
            'name' => $row['name'],
            'model' => $row['model'],
            'year' => $row['year'],
            'id' => $row['id']
        );
        array_push($output, $outputItem);
    }

    echo json_encode($output);
//    echo json_encode(array('message' => "Nothing"));
    die();
}

$content = file_get_contents('http://localhost/php/HALPv2/api/manufacturers/read_single_manufacturer.php?id=' . $id);
$json = json_decode($content, true);

$sql2 = "SELECT * FROM phones WHERE manufacturer_id = '$id' ORDER BY year DESC, model DESC";
$stmt = $db->prepare($sql2);
$stmt->execute();

$output = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $outputItem = array(
        'name' => $json['name'],
        'model' => $row['model'],
        'year' => $row['year'],
        'id' => $row['id']
    );
    array_push($output, $outputItem);
}

echo json_encode($output);