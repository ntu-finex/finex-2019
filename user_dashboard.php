<?php
    session_start();
    include('inc/header.php');
    require('secure/connect.php');
    if(isset($_SESSION['teamName']) == ""){
        header("Location: index.php");
    }
?>

<body>
    <div class="container">
        <h1>User Dashboard</h1>
    </div>
</body>