<?php
	session_start();
	
	if(isset($_SESSION['admin_id'])!=''){
		header("Location:admin_index.php");
	}
	
	include_once '../secure/connect.php';
		//check if form is submitted
	if(isset($_POST['login'])){
		
		$admin_name = mysqli_real_escape_string($connection, $_POST['admin_name']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		$result=mysqli_query($connection,"SELECT * FROM admin WHERE admin_name = '" . $admin_name. "' and password = '" . $password . "'");
		
		if ($row = mysqli_fetch_array($result)){
			$_SESSION['admin_id'] = $row['id'];
			$_SESSION['admin_name'] = $row['admin_name'];
			header("Location: admin_index.php");
		} else {
			$errormsg="Incorrect ID or Password!!!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Finex Admin Login System</title>
	<meta charset="utf-8">
	<meta content="width=device-width,initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="../css/w3.css" type="text/css" />
	<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kreon" rel="stylesheet">
	<style>
		.fw1{
			font-weight:1;
		}
		.spacebetweeninput{
			margin-bottom:.5rem;
		}
	</style>
</head>
<body>
	<br/>
	<div class="w3-container w3-content">
		<div class="w3-container spacebetweeninput">
			<h3 class="w3-text-red fw1">FINEX Admin Login</h3>
		</div>
        <div>
		<form class="w3-container" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
			<div class="spacebetweeninput">
				<h5 class="fw1">Admin Name</h5>
				<input style="width:60%;" type="text" name="admin_name" required class="w3-input w3-border" />
			</div>
			<div class="spacebetweeninput">
				<h5 class="fw1">Password</h5>
				<input type="password" style="width:60%;" name="password" required class="w3-input w3-border" />
			</div>
			<br/>
			<div>
				<button class="btn btn-dark" name="login" style="margin-right:20px;"> Register </button>
			</div>
			</form>
        </div>
	</div>
</body>
</html>