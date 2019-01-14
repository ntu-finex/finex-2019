<?php

require_once('../secure/config.php');
session_start();
$servername = DB_HOST;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$buyer = $_SESSION['teamName'];
$stockName = $_GET['name'];

//display all stocks owned by the user.
$query = $conn->prepare('SELECT * FROM stocks WHERE name=? AND owner = ?');
$query->execute([$stockName,$buyer]);
$stocks = $query->fetchAll();

echo json_encode($stocks);

?>