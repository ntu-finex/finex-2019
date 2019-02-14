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
$name = $_POST['name']; //name of the stock
//$sale_id = $_POST['id'];
$qty = $_POST['quantity'];

$stmt = $conn->prepare("SELECT * FROM teams where teamName=?");
$stmt->execute([$seller]);
$user = $stmt->fetch();
$listing_count = $user['listing_count'];

if($listing_count >= 5){
  echo 'You have already listed 5 stocks for sale';
  return false;
}

$query = $conn->prepare("SELECT * FROM stocks where available = 0 and owner=? and name=?"); //fetch all the stocks with the name and belong to the owner and available for list
$query->execute([$seller,$name]);

if($query->rowCount() == 0){
    echo 'You don\'t have any stock for sale.';
    return false;
}else if($query->rowCount() < $qty){
    echo 'You don\'t have sufficient stock for sale.';
    return false;
}else{
    //here i need to think of how to pass the sale_id and set the correct one
    $stocks = $query->fetchAll();

    switch($listing_count){
      case 0: $sale_id = "sale_1"; break;
      case 1: $sale_id = "sale_2"; break;
      case 2: $sale_id = "sale_3"; break;
      case 3: $sale_id = "sale_4"; break;
      case 4: $sale_id = "sale_5"; break;
    }

    for($i = 0 ; $i < $qty; $i++){
      $id = $stocks[$i]['id'];
      $sql = $conn->prepare("UPDATE stocks SET price = ?, available = 1, ".$sale_id."=1 WHERE id =?");
      $sql->execute([$price,$id]);
    }

    $listing_count++;

    $stmt = $conn->prepare("UPDATE teams SET listing_count = ? WHERE teamName=?");
    $stmt->execute([$listing_count,$seller]);

    echo $name;
}

?>
