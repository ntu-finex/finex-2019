<?php
    require_once('../secure/config.php');
    session_start();
    $servername = DB_HOST;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_POST['id'];
    // $stockName = $_POST['stockName'];
    // $owner = $_POST['owner'];
    $buyer = $_SESSION['teamName'];

    // $query = $conn->prepare("SELECT * FROM stocks WHERE id=? AND name=? AND owner=? AND available = 1");
    $query = $conn->prepare("SELECT * FROM stocks WHERE id=? AND available = 1");
    $query->execute([$id]);

    //stock is not available for purchase or stock is unavailable.
    if($query->rowCount() == 0){
        echo 'Stock is unavailable for purchase.';
    }else{ //stock is available for purchase, check the buyer money is enough to buy the stock
        $stock = $query->fetch();
        $price = $stock['price']; //price of stock

        $sql = $conn->prepare("SELECT * FROM teams WHERE teamName=?");
        $sql->execute([$buyer]);
        $buyerCash = ($sql->fetch())['cash']; //cash that the buyer own
        $seller = $stock['owner'];

        if($price > $buyerCash){
            echo "You don't have enough cash to purchase the stocks.";
        }else{
            //deduct cash from buyer
            $update = $conn->prepare("UPDATE teams SET cash = ? WHERE teamName =?");
            $update->execute([$buyerCash-$price,$buyer]);

            //update ownership of the stock
            $stmt = $conn->prepare("UPDATE stocks SET available = 0 , owner = ? WHERE id = ?");
            $stmt->execute([$buyer, $id]);

            //add cash to seller of the stock
            $query = $conn->prepare("SELECT * FROM teams WHERE teamName=?");
            $query->execute([$seller]);
            $sellerCash = ($query->fetch())['cash'];

            $update = $conn->prepare("UPDATE teams SET cash =? WHERE teamName = ?");
            $update->execute([$sellerCash+$price,$seller]);


            echo $stock['name'];
        }   
    }

?>