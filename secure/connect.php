<?php

	$connection = mysqli_connect("localhost","root","","ntu-iic_database") or
	die ("Having trouble connect to database.".mysqli_error($connection));

	// if(mysqli_connect("localhost","ntu-i_root", "a1a2a3", "ntu-iic_database")){
	// 	$connection = mysqli_connect("localhost","root", "", "ntu-iic_database");
	// 	echo "Connected to database successfully";
	// }else{
	// 	die("Connection to database failed".mysqli_error($connection));
	// }
	
?>