<?php
	session_start();
	
	if(isset($_SESSION['station_name'])) {
		session_destroy();
		session_unset();
		//unset($_SESSION['station_name']);
		//unset($_SESSION['name']);
		header("Location: gm_index.php");
	} else {
		header("Location: gm_index.php");
	}
	
?>