<!DOCTYPE html>
<html>
<head>
	<title>Financial Expedition 2019</title>
	<meta charset="utf-8">
	<meta content="width=device-width,initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/w3.css" type="text/css" />
    <link rel="icon" href="images/FinexLogo.jpeg"/>
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script> 
    <link href="https://fonts.googleapis.com/css?family=Kreon" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous"></head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background:white;">
	<a class="navbar-brand" href="#"><img class="logo" src="images/logo.png" height="40"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav ml-auto"> 
            <li class="nav-item active">
            <a class="nav-link" href="admin_dashboard.php">Home</a>
            </li>
            <?php 
                if(isset($_SESSION["station"]) == ""){
                    echo '<li class="nav-item"><a class="nav-link" href="admin_login.php">Login</a></li>';
                }else{
                    echo '<li class="nav-item"><a class="nav-link" href="php/admin_logout_process.php">Logout</a></li>';
                }
            ?>
            <!-- <li class="nav-item dropdown"> -->
            <!-- <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">Dropdown</a> -->
        </ul>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"> Menu item 1</a></li>
            <li><a class="dropdown-item" href="#"> Menu item 2 </a></li>
        </ul>
    </div>
</nav>
</body>

<style>
    nav{
        box-shadow: 0 1px 10px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    }
</style>