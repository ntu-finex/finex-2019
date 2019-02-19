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
            case 3: $points = $_POST['points'];
                    $team = $_POST['name'];
                    $stationNum = $_POST['station_num'];
                    setPoints($team,$points,$stationNum);
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

    function setPoints($teamName, $points,$stationNum){
        $servername = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //fetch the current cash
        $queryMark = $conn->prepare("SELECT * FROM teams WHERE teamName=?");
        $queryMark->execute([$teamName]);
        $team = $queryMark->fetch();
        $currentMark = $team['cash'];
        $currentMark = $currentMark + $points;

        switch($stationNum){
            case "station_1": $query = $conn->prepare("UPDATE teams SET station_1=?,cash=? WHERE teamName=?");
                                break;
            case "station_2": $query = $conn->prepare("UPDATE teams SET station_2=?,cash=? WHERE teamName=?");
                                break;
            case "station_3": $query = $conn->prepare("UPDATE teams SET station_3=?,cash=? WHERE teamName=?");
                                break;
            case "station_4": $query = $conn->prepare("UPDATE teams SET station_4=?,cash=? WHERE teamName=?");
                                break;
            case "station_5": $query = $conn->prepare("UPDATE teams SET station_5=?,cash=? WHERE teamName=?");
                                break;
            default: echo "Got Error"; break;
        }


        echo($query->execute([$points, $currentMark, $teamName]));

    }
?>
