<?php
	session_start();
	
	if(isset($_SESSION['teamname'])) {
		session_destroy();
		session_unset();
		header("Location: index.php");
	} else {
		header("Location: index.php");
	}
	
?>