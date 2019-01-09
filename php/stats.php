<?php
    require_once('../secure/config.php');
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $teamName = $_SESSION['teamName'];
    
    if(isset($_POST['choice'])){
        switch($_POST['choice']){
            case 1: echo round(getCash($teamName)['cash'],2);
                    break;
            case 2:  echo round(getPoints($teamName)['game_points'],2);
                    break;
        }
        
    }
    
    function getPoints($teamName){
        $servername = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $conn->prepare("SELECT game_points FROM teams WHERE teamName =?");
        $query->execute([$teamName]);
        $game_points = $query->fetch();

        return $game_points;
    }

    function getCash($teamName){
        $servername = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $conn->prepare("SELECT cash FROM teams WHERE teamName=?");
        $query->execute([$teamName]);
        $cash = $query->fetch();

        return $cash;
    }

    // function storePoint($teamName){

    // }
?>