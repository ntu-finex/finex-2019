<?php
    require_once('../secure/config.php');
    session_start();
    $servername = DB_HOST;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $buyer = $_SESSION['teamName'];
    $seller = $_POST['seller'];
    $sale_id = $_POST['sale_id'];

    // $query = $conn->prepare("SELECT * FROM stocks WHERE id=? AND name=? AND owner=? AND available = 1");
    $query = $conn->prepare("SELECT * FROM stocks WHERE ".$sale_id." = 1 AND available = 1 AND owner=?");
    $query->execute([$seller]);

    //stock is not available for purchase or stock is unavailable.
    if($query->rowCount() == 0){
        echo 'Stock is unavailable for purchase.';
    }else{ //stock is available for purchase, check the buyer money is enough to buy the stock
        $stocks = $query->fetchAll();
        $stocks_qty = $query->rowCount();
        $price = $stocks[0]['price'] * $stocks_qty; //price of stock

        $sql = $conn->prepare("SELECT * FROM teams WHERE teamName=?");
        $sql->execute([$buyer]);
        $buyerCash = ($sql->fetch())['cash']; //cash that the buyer own

        if($price > $buyerCash){
            echo "You don't have enough cash to purchase the stocks.";
        }else{
            //deduct cash from buyer
            $update = $conn->prepare("UPDATE teams SET cash = ? WHERE teamName =?");
            $update->execute([$buyerCash-$price,$buyer]);

            //update ownership of the stock
            $stmt = $conn->prepare("UPDATE stocks SET ".$sale_id."=0,available = 0 , owner = ? WHERE ".$sale_id."=1 AND owner = ?");
            $stmt->execute([$buyer, $seller]);

            //add cash to seller of the stock
            $query = $conn->prepare("SELECT * FROM teams WHERE teamName=?");
            $query->execute([$seller]);
            $sellerCash = ($query->fetch())['cash'];
            $listing_count = ($query->fetch())['listing_count'];

            $listing_count++;
            $update = $conn->prepare("UPDATE teams SET cash =? , listing_count =? WHERE teamName = ?");
            $update->execute([$sellerCash+$price,$listing_count,$seller]);


            echo $stocks[0]['name'];
        }
    }

?>
