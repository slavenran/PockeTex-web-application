
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../database/Database.php';
include_once '../../models/Manufacturers.php';

$database = new Database();
$db = $database->connect();

$manufacturer = new Manufacturers($db);

$getId = isset($_GET['id']) ? $_GET['id'] : die();

$isWished = "";
if(!isset($_POST['id']) && !isset($_POST['model'])) {
    $sql2 = "SELECT m.name, p.model, p.year, p.image, p.storage, p.resolution, p.cost, p.description, p.id FROM phones p, manufacturers m WHERE m.id = p.manufacturer_id";
    $stmt = $db->prepare($sql2);
    $stmt->execute();

    $output = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sql3 = "SELECT round(avg(rating), 1) as 'averageRat' FROM `ratings` WHERE phones_id_rating = " . $row['id'];
        $ratings = $db->prepare($sql3);
        $ratings->execute();
        $rowR = $ratings->fetch(PDO::FETCH_ASSOC);
        $averageRat = "";
        if($rowR['averageRat'] != null) {
            $averageRat = $rowR['averageRat'];
        } else {
            $averageRat = "No ratings";
        }

        $sqlUserRating = "SELECT rating FROM `ratings` WHERE phones_id_rating = ". $row['id'] ." AND users_id_rating = '$getId'";
        $ratingsUser = $db->prepare($sqlUserRating);
        $ratingsUser->execute();
        $rowRU = $ratingsUser->fetch(PDO::FETCH_ASSOC);
        $userRat = "";
        if($rowRU['rating'] != null) {
            $userRat = $rowRU['rating'];
        } else {
            $userRat = 0;
        }

        $sqlBena = "SELECT count(w.phones_id_wishlist) from wishlist w WHERE w.users_id_wishlist = '$getId' and w.phones_id_wishlist = " . $row['id'] . " GROUP BY w.phones_id_wishlist";
        $wished = $db->prepare($sqlBena);
        $wished->execute();
        $isItWished = $wished->fetch(PDO::FETCH_ASSOC);
        if($isItWished != 0) {
            $isWished = "wished";
        } else {
            $isWished = "notWished";
        }

        $outputItem = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'model' => $row['model'],
            'year' => $row['year'],
            'image' => $row['image'],
            'storage' => $row['storage'],
            'resolution' => $row['resolution'],
            'cost' => $row['cost'],
            'description'=> $row['description'],
            'averageRating' => $averageRat,
            'userRating' => $userRat,
            'isWished' => $isWished
        );
        array_push($output, $outputItem);
    }

    echo json_encode($output);
//    echo json_encode(array('message' => "Nothing"));
    die();
}

$id = $_POST['id'];
$model = $_POST['model'];

if($id == "ori"){
    $sql2 = "SELECT m.name, p.model, p.year, p.image, p.id FROM phones p, manufacturers m WHERE m.id = p.manufacturer_id AND model LIKE '%$model%'";
    $stmt = $db->prepare($sql2);
    $stmt->execute();

    $output = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sql3 = "SELECT round(avg(rating), 1) as 'averageRat' FROM `ratings` WHERE phones_id_rating = " . $row['id'];
        $ratings = $db->prepare($sql3);
        $ratings->execute();
        $rowR = $ratings->fetch(PDO::FETCH_ASSOC);
        $averageRat = "";
        if($rowR['averageRat'] != null) {
            $averageRat = $rowR['averageRat'];
        }

        $outputItem = array(
            'name' => $row['name'],
            'model' => $row['model'],
            'year' => $row['year'],
            'image' => $row['image'],
            'averageRat' => $averageRat
        );
        array_push($output, $outputItem);
    }

    echo json_encode($output);
//    echo json_encode(array('message' => "Nothing"));
    die();
}

$content = file_get_contents('http://localhost/php/HALPv2/api/manufacturers/read_single_manufacturer.php?id=' . $id);
$json = json_decode($content, true);

$sql2 = "SELECT * FROM phones WHERE manufacturer_id = '$id' and model like '%$model%' ORDER BY year DESC, model DESC";
$stmt = $db->prepare($sql2);
$stmt->execute();

$output = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sql3 = "SELECT round(avg(rating), 1) as 'averageRat' FROM `ratings` WHERE phones_id_rating = " . $row['id'];
    $ratings = $db->prepare($sql3);
    $ratings->execute();
    $rowR = $ratings->fetch(PDO::FETCH_ASSOC);
    $averageRat = "";
    if($rowR['averageRat'] != null) {
        $averageRat = $rowR['averageRat'];
    }

    $outputItem = array(
        'name' => $json['name'],
        'model' => $row['model'],
        'year' => $row['year'],
        'image' => $row['image'],
        'averageRat' => $averageRat
    );
    array_push($output, $outputItem);
}

echo json_encode($output);