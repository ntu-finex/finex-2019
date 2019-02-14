<?php
    require_once('../secure/config.php');
    session_start();
    $servername = DB_HOST;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $qty = $_POST['quantity'];
    $stockName = $_POST['stock'];
    $owner = $_POST['owner'];
    $buyer = $_SESSION['teamName'];

    // $query = $conn->prepare("SELECT * FROM stocks WHERE id=? AND name=? AND owner=? AND available = 1");
        $query = $conn->prepare("SELECT * FROM stocks WHERE name=? AND owner=? AND available = 1");
        $query->execute([$stockName,$owner]);

        //stock is not available for purchase or stock is unavailable.
        if($query->rowCount() == 0){
            echo 'Stock is unavailable for purchase.';
        }else if($query->rowCount() < $qty){
            echo 'Insufficient stock for purchase.';
        }else{ //stock is available for purchase, check the buyer money is enough to buy the stock
            $stocks = $query->fetchAll();
            $total_price = 0;
            $ids = array();

            for($i = 0; $i < $qty; $i++){
                $total_price += $stocks[$i]['price'];
                array_push($ids,$stocks[$i]['id']);
            }

            $sql = $conn->prepare("SELECT * FROM teams WHERE teamName=?");
            $sql->execute([$buyer]);
            $buyerCash = ($sql->fetch())['cash']; //cash that the buyer own

            if($total_price > $buyerCash){
                echo "You don't have enough cash to purchase the stocks.";
            }else{
                //deduct cash from buyer
                $update = $conn->prepare("UPDATE teams SET cash = ? WHERE teamName =?");
                $update->execute([$buyerCash-$total_price,$buyer]);

                //update ownership of the stock
                for($i = 0; $i < $qty; $i++){
                    $id = $ids[$i];
                    $stmt = $conn->prepare("UPDATE stocks SET available = 0 , owner = ? WHERE id = ?");
                    $stmt->execute([$buyer, $id]);
                }

                echo $stockName;
            }   
        }
    
    

?>