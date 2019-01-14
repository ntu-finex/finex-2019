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
$description = $_POST['description']; //description of the stock
$name = $_POST['name']; //name of the stock

$query = $conn->prepare("SELECT * FROM stocks where owner=? and available = 0 and name=?");
$query->execute([$seller,$name]);

if($query->rowCount() == 0){
    echo 'You don\'t have any stock for sale.';
}else{
    $stock = $query->fetch();
    $id = $stock['id'];
    $sql = $conn->prepare("UPDATE stocks SET price = ?, available = 1 WHERE id =?");
    $sql->execute([$price,$id]);

    echo 'The stock is listed for sale.';
}

?>