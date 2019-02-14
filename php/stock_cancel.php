<?php
//cancel the listing of the stock
require_once('../secure/config.php');
session_start();
$servername = DB_HOST;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$seller = $_SESSION['teamName'];
$sale_id = $_POST['id'];

$query = $conn->prepare("SELECT * FROM stocks where available = 1 and ".$sale_id."=1 and owner=?");
$query->execute([$seller]);

if($query->rowCount() == 0){
    echo 'You don\'t have any stock for cancellation.';
}else{
    $stock = $query->fetch();
    $sql = $conn->prepare("UPDATE stocks SET available = 0,".$sale_id."=0 WHERE available = 1 and ".$sale_id."=1 and owner=?");
    $sql->execute([$seller]);

    $stmt = $conn->prepare("SELECT * FROM teams where teamName=?");
    $stmt->execute([$seller]);
    $user = $stmt->fetch();
    $listing_count = $user['listing_count'];
    $listing_count--;

    $stmt = $conn->prepare("UPDATE teams SET listing_count=? WHERE teamName =?");
    $stmt->execute([$listing_count, $seller]);

    echo $stock['name'];
}

?>
