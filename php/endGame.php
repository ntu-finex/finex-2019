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
  $update = $conn->prepare("UPDATE teams SET cash=? WHERE teamName =?");
  $sql = $conn->prepare("SELECT cash FROM teams WHERE teamName=?");
  $updateStock = $conn->prepare("UPDATE stocks SET available = 0, owner=? WHERE id=?");

  for($i = 0; $i < $stocksCount; $i++){
    $owner = $stocks[$i]['owner'];
    $stockName = $stocks[$i]['name'];
    $id = $stocks[$i]['id'];

    if($sql->execute([$owner])){
      $cash = $sql->fetchColumn(); //fetch the cash that the user has right now
        switch($stockName){ //set the price to be added
          case $stock1: $cash += $current_price1; break;
          case $stock2: $cash += $current_price2; break;
          case $stock3: $cash += $current_price3; break;
          case $stock4: $cash += $current_price4; break;
        }
        $update->execute([$cash, $owner]); //add converted cash to user's account
        //update stock to not available for sale and back to og owner
        $updateStock->execute([$stockName, $id]);
    }else{
      echo $owner.' is not in the list of teams!';
      return false;
    }
  }

  echo 'The process is done.';
  return false;
 ?>
