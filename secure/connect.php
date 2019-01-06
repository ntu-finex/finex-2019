<?php

	// $connection = mysqli_connect("localhost","root","","ntu-iic_database") or
	// die ("Having trouble connect to database.".mysqli_error($connection));

	// if(mysqli_connect("localhost","ntu-i_root", "a1a2a3", "ntu-iic_database")){
	// 	$connection = mysqli_connect("localhost","ntu-i_root", "a1a2a3", "ntu-iic_database");
	// }else{
	// 	die("Connection to database failed".mysqli_error($connection));
	// }
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	// $username = "ntu-i_root";
	// $password = "a1a2a3";
	$dbname = "ntu-iic_database";

	try {
		//Creating connection for mysql
		$conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
?>