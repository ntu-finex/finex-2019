<?php
	session_start();
	if(isset($_SESSION['admin_name'])){
		$admin_name=$_SESSION['admin_name'];
	}else{ 
		header('Location: admin_login.php');
	}
	include '../secure/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Finex 2018 Registration</title>
	<meta charset="utf-8">
	<meta content="width=device-width,initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="../css/w3.css" type="text/css" />
	<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kreon" rel="stylesheet">
</head>
<body>
	<?php
		include 'navbar.html';
	?>
</body>
</html>