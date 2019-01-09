<?php
    require_once('../secure/config.php');
    session_start();
    $servername = DB_HOST;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_POST['id'];
    $stockName = $_POST['stockName'];
    $owner = $_POST['owner'];
    $buyer = $_SESSION['teamName'];

    $query = $conn->prepare("SELECT * FROM stocks WHERE id=? AND name=? AND owner=? AND available = 1");
    $query->execute([$id,$stockName,$owner]);

    //stock is not available for purchase or stock is unavailable.
    if($query->rowCount() == 0){
        echo 'Stock is unavailable for purchase.';
    }else{ //stock is available for purchase, check the buyer money is enough to buy the stock
        $stock = $query->fetch();
        $price = $stock['price']; //price of stock

        $sql = $conn->prepare("SELECT * FROM teams WHERE teamName=?");
        $sql->execute([$buyer]);
        $cash = ($sql->fetch())['cash']; //cash that the buyer own

        if($price > $cash){
            echo "You don't have enough cash to purchase the stocks.";
        }else{
            $update = $conn->prepare("UPDATE teams SET cash = ? WHERE teamName =?");
            $update->execute([$cash-$price,$buyer]);

            $stmt = $conn->prepare("UPDATE stocks SET available = 0 , owner = ? WHERE id = ? AND name=?");
            $stmt->execute([$buyer, $id, $stockName]);

            echo 'Stock successfully purchased.';
        }   
    }

?>