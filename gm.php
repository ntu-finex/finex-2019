<?php

session_start();
include('inc/admin_header.php');
include('secure/connect.php');
if(isset($_SESSION['station']) == ""){
    header("Location: admin_login.php");
}

$stationName = $_SESSION['station'];
$stationNum = $_SESSION['stationNum'];
?>

<body>
    <br>
    <div class="container">
        <h2>Current Scenario</h2>
        <hr>
        
    </div>
</body>
