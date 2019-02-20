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
$listing_count1 = $user['listing_count1'];
$listing_count2 = $user['listing_count2'];
$listing_count3 = $user['listing_count3'];
$listing_count4 = $user['listing_count4'];
$listing_count5 = $user['listing_count5'];

if(($listing_count1+$listing_count2+$listing_count3+$listing_count4+$listing_count5) == 5){
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

    /*switch($listing_count){
      case 0: $sale_id = "sale_1"; break;
      case 1: $sale_id = "sale_2"; break;
      case 2: $sale_id = "sale_3"; break;
      case 3: $sale_id = "sale_4"; break;
      case 4: $sale_id = "sale_5"; break;
    }*/

    if($listing_count1 == 0){
      $sale_id = "sale_1";
    }else if($listing_count2 == 0){
      $sale_id = "sale_2";
    }else if($listing_count3 == 0){
      $sale_id = "sale_3";
    }else if($listing_count4 == 0){
      $sale_id = "sale_4";
    }else{
      $sale_id = "sale_5";
    }

    for($i = 0 ; $i < $qty; $i++){
      $id = $stocks[$i]['id'];
      $sql = $conn->prepare("UPDATE stocks SET price = ?, available = 1, ".$sale_id."=1 WHERE id =?");
      $sql->execute([$price,$id]);
    }

    switch($sale_id){
      case "sale_1": $listing_count1++;
                      $stmt = $conn->prepare("UPDATE teams SET listing_count1 = ? WHERE teamName=?");
                      $stmt->execute([$listing_count1,$seller]);
                      break;
      case "sale_2": $listing_count2++;
      $stmt = $conn->prepare("UPDATE teams SET listing_count2 = ? WHERE teamName=?");
      $stmt->execute([$listing_count2,$seller]);
      break;
      case "sale_3": $listing_count3++;
      $stmt = $conn->prepare("UPDATE teams SET listing_count3 = ? WHERE teamName=?");
      $stmt->execute([$listing_count3,$seller]);
      break;
      case "sale_4": $listing_count4++;
      $stmt = $conn->prepare("UPDATE teams SET listing_count4 = ? WHERE teamName=?");
      $stmt->execute([$listing_count4,$seller]);
      break;
      case "sale_5": $listing_count5++;
      $stmt = $conn->prepare("UPDATE teams SET listing_count5 = ? WHERE teamName=?");
      $stmt->execute([$listing_count5,$seller]);
      break;
    }


    echo $name;
}

?>
