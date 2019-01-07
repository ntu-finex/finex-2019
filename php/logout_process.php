<?php
	session_start();
	
	if(isset($_SESSION['teamName'])) {
		session_destroy();
		session_unset();
		header("Location: ../index.php");
	} else {
		header("Location: ../index.php");
	}
	
?>