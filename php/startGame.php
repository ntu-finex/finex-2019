<?php
  require_once('../secure/config.php');
  $servername = DB_HOST;
  $username = DB_USERNAME;
  $password = DB_PASSWORD;
  $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->prepare("SELECT * FROM market_stocks");
  $stmt->execute([]);

  //fetch the market_stocks price
  $marketStocks = $stmt->fetchAll();
  $stock1 = $marketStocks[0]['name'];
  $stock2 = $marketStocks[1]['name'];
  $stock3 = $marketStocks[2]['name'];
  $stock4 = $marketStocks[3]['name'];
  $current_price1 = $marketStocks[0]['current_price'];
  $current_price2 = $marketStocks[1]['current_price'];
  $current_price3 = $marketStocks[2]['current_price'];
  $current_price4 = $marketStocks[3]['current_price'];

  //fetch all stocks
  $query = $conn->prepare("SELECT * FROM stocks");
  $query->execute();
  $stocks = $query->fetchAll();
  $stocksCount = $query->rowCount();

  // TODO: loop through all the stocks to see who they belong to
  //        and then convert them to cash and at the same time set them
  //       back to not available for sale :)
  $updateStock = $conn->prepare("UPDATE stocks SET available = 1,price=? WHERE name=?");
  $enable = $conn->prepare("UPDATE utility SET number = 0 WHERE name='button_disabled'"); //disable the button

  $updateStock->execute([$current_price1,$stock1]);
  $updateStock->execute([$current_price2,$stock2]);
  $updateStock->execute([$current_price3,$stock3]);
  $updateStock->execute([$current_price4,$stock4]);
  $enable->execute();


  echo 'The process is done.';
  return false;
 ?>
