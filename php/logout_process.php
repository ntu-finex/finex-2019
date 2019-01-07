<?php
	session_start();
	
	if(isset($_SESSION['teamName'])) {
		session_destroy();
		session_unset();
		header("Location: ../public_html/index.php");
	} else {
		header("Location: ../public_html/index.php");
	}
	
?>