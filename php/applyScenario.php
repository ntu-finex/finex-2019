<?php
  require_once('../secure/config.php');
  $servername = DB_HOST;
  $username = DB_USERNAME;
  $password = DB_PASSWORD;
  $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $targetScenario = $_POST['scenarioID'];
    
  $querySce = $conn->prepare("SELECT * FROM scenarios WHERE id=?");
  $querySce->execute([$targetScenario]);
  $scenario = $querySce->fetchAll();
  //check if there's this scenario

  if(count($scenario) != 1){
      echo 'Scenario is not available! Aborted!';
      return true;
  }
  $updateSce = $conn->prepare("UPDATE scenarios SET available = 0 WHERE id=?");
  $updateSce->execute([$targetScenario]);

  $effect = $scenario[0]['effect'];
  $affectedID1 = $scenario[0]['stockID_1'];
  $affectedID2 = $scenario[0]['stockID_2'];
  
  //update the current scenario
  $updateSce = $conn->prepare("UPDATE utility SET number=? WHERE name='current_sce'");
  $updateSce->execute([$targetScenario]);

  //query the current market price
  $queryMarketPrice = $conn->prepare("SELECT * FROM market_stocks WHERE id=?");
  $queryMarketPrice->execute([$affectedID1]);
  $priceStock1 = $queryMarketPrice->fetch()['current_price'];

  if($affectedID2 != 0){
    $queryMarketPrice->execute([$affectedID2]);
    $priceStock2 = $queryMarketPrice->fetch()['current_price'];
    $newPrice2 = $priceStock2 * $effect;
  }

  //apply effects
  $newPrice1 = $priceStock1 * $effect;


  //update the previous_price and current_price
  $updatePrice = $conn->prepare("UPDATE market_stocks SET previous_price=?, current_price=? WHERE id=?");
  $updatePrice->execute([$priceStock1,$newPrice1,$affectedID1]);

  if($affectedID2 != 0){
    $updatePrice->execute([$priceStock2,$newPrice2,$affectedID2]);      
  }

  echo 'Stock price successfully updated!';
  return true;
  
 ?>
