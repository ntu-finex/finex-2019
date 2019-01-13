<?php

require_once('../secure/config.php');
session_start();
$servername = DB_HOST;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'];
$price = $_POST['price'];

$query = $conn->prepare("SELECT * FROM stocks where id=?");
$query->execute([$id]);

if($query->rowCount() == 0){
    echo 'Stock is unavailable for sale.';
}else{
    $stock = $query->fetch();
    $sql = $conn->prepare("UPDATE stocks SET price = ?, available = 1 WHERE id =?");
    $sql->execute([$price,$id]);

    echo 'The stock is listed for sale.';
}

?>