<?php
	session_start();
	
	if(isset($_SESSION['station'])) {
		session_destroy();
		session_unset();
		header("Location: ../admin_login.php");
	} else {
		header("Location: ../admin_login.php");
	}
	
?>