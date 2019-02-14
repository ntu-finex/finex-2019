<?php
  $stockName = $prices = 0;
  require_once('../secure/config.php');
  $servername = DB_HOST;
  $username = DB_USERNAME;
  $password = DB_PASSWORD;
  $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if(isset($_POST['submit'])){
    $stockName = $_POST['stockName'];
    $prices = $_POST['price'];

    $stmt = $conn->prepare("SELECT * FROM market_stocks WHERE name=?");
    $stmt->execute([$stockName]);
    $stock = $stmt->fetch();

    $previous = $stock['current_price'];

    $query = $conn->prepare("UPDATE market_stocks SET previous_price=?, current_price=? WHERE name=?");
    $query->execute([$previous, $prices, $stockName]);

    header("Location: ../gm.php");
  }


 ?>
