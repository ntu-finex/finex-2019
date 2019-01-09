<?php
require_once('secure/config.php');
class Stock{
    private $id;
    private $name; //name of the stock
    private $price; 
    private $owner; //owned by company/team
    private $conn;
    
    function __construct(){
        $servername = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $this->conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getStockByID($id){
        $query = $this->conn->prepare("SELECT * FROM stocks WHERE id = ?");
        $query->execute([$id]); 
        $stock = $query->fetch();

        return $stock;
    }

    public function getStockByOwner($owner){
        $query = $this->conn->prepare("SELECT * FROM stocks WHERE owner =?");
        $query->execute([$owner]);
        $stocks = $query->fetch();

        return $stocks;
    }

    public function getStocksByCompany($name){
        $query = $this->conn->prepare("SELECT * FROM stocks WHERE name=? AND available = 1");
        $query->execute([$name]);
        $stocks = $query->fetch();

        return $stocks;
    }

    public function getPrice($id){
        return $this->getStockByID($id)['price'];
    }

    public function getName($id){
        return $this->getStockByID($id)['name'];
    }

    public function getOwner($id){
        return $this->getOwnerByID($id)['owner'];
    }
 
    public function getCompanyStock($stockName){
        $query = $this->conn->prepare("SELECT * FROM market_stocks WHERE name=?");
        $query->execute([$stockName]);
        $stock = $query->fetch();

        return $stock;
    }
    public function getCurrentMarketPrice($stockName){
        $query = $this->conn->prepare("SELECT * FROM market_stocks WHERE name=?");
        $query->execute([$stockName]);
        $stock = $query->fetch();

        return $stock['current_price'];
    }

    public function getPreviousMarketPrice($stockName){
        $query = $this->conn->prepare("SELECT * FROM market_stocks WHERE name=?");
        $query->execute([$stockName]);
        $stock = $query->fetch();

        return $stock['previous_price'];
    }

    public function getStockQuantity($stockName){
        $query = $this->conn->prepare("SELECT * FROM market_stocks WHERE name=?");
        $query->execute([$stockName]);
        $stock = $query->fetch();

        return $stock['quantity'];
    }
}

?>