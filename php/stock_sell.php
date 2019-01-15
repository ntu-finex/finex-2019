<?php

require_once('../secure/config.php');
session_start();
$servername = DB_HOST;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$seller = $_SESSION['teamName'];
$price = $_POST['price']; //selling price
// $name = $_POST['name']; //name of the stock
$id = $_POST['id'];

$query = $conn->prepare("SELECT * FROM stocks where available = 0 and id=?");
$query->execute([$id]);

if($query->rowCount() == 0){
    echo 'You don\'t have any stock for sale.';
}else{
    $stock = $query->fetch();
    $sql = $conn->prepare("UPDATE stocks SET price = ?, available = 1 WHERE id =?");
    $sql->execute([$price,$id]);

    echo $stock['name'];
}

?>