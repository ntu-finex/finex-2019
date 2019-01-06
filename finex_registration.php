<?php
	session_start();

	include 'secure/connect.php';
	
	//set validation error flag as false
	$error=false;
	
	//check if form is submitted
	if(isset($_POST['signup'])){
		$name=mysqli_real_escape_string($connection,$_POST['name']);
		$captainemail=mysqli_real_escape_string($connection,$_POST['captainemail']);
        $twoemail=mysqli_real_escape_string($connection,$_POST['twoemail']);
        $threeemail=mysqli_real_escape_string($connection,$_POST['threeemail']);
		$contact_number=mysqli_real_escape_string($connection,$_POST['contact_number']);
		
		//check whether the detials r used???
		$checkteamname="SELECT teamname FROM finex_2018_registration WHERE teamname='".$name."'";
		$teamnameresult=mysqli_query($connection,$checkteamname);
		if(mysqli_num_rows($teamnameresult)!=0){
			$error= true;
			$name_error = "Someone is using this team name. Try another ;)";
		}
		$check="SELECT email FROM finex_2018_registration WHERE email='".$captainemail."'";
		$checkresult=mysqli_query($connection,$check);
		if(mysqli_num_rows($checkresult)!=0){
			$error= true;
			$email_error = "Someone is using your email. Try another ;)";
		}
		if(!filter_var($captainemail,FILTER_VALIDATE_EMAIL)) {
			$error = true;
			$email_error = "Please Enter Valid Email ID";
		}
		
		if(strlen($contact_number)!=8){
			$error = true;
			$contact_error = "8 digit numbers only";
		}
		
		if(!$error){
			if(mysqli_query($connection,"INSERT INTO finex_2018_registration(teamname,email,email2,email3,contact_number) 
			VALUES('" . $name . "', '" . strtolower($captainemail). "', '" . strtolower($email2) . "', '" . strtolower($email3). "', '" . $contact_number . "')")){
				$successmsg="Successfully Registered! We will email you details soon :)";
			} else{
				$errormsg="Error in registering...Please try again later!";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Finex 2018 Registration</title>
	<meta charset="utf-8">
	<meta content="width=device-width,initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/w3.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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
	<?php include 'navbar.html'; ?>
	<br/>
	<div class="w3-container w3-content">
		<div class="w3-container" style="margin-bottom:1rem;">
			<h3 class="w3-text-red fw1">FINEX 2018 REGISTRATION</h3>
		</div>
        <div>
		<form class="w3-container" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
			<div class="spacebetweeninput">
				<h5 style="font-family: 'Kreon', serif;">Team Name</h5>
				<input style="width:60%;" type="text" value="<?php echo $name;?>" name="name" placeholder="Team Name here!" required autofocus class="w3-input w3-border" />
				<span class="text-danger" style="color:red;"><?php if (isset($name_error)) echo $name_error; ?></span>
			</div>
			<div class="spacebetweeninput">
				<h5 style="font-family: 'Kreon', serif;">Captain's Email</h5>
				<input type="text" style="width:60%;" value="<?php echo $captainemail;?>" name="captainemail" placeholder="Email here!" required class="w3-input w3-border" />
				<span class="text-danger" style="color:red;"><?php if (isset($email_error)) echo $email_error; ?></span>
			</div>
            <div class="spacebetweeninput">
				<h5 style="font-family: 'Kreon', serif;">2nd member's Email</h5>
				<input type="text" style="width:60%;" value="<?php echo $twoemail;?>" name="twoemail" placeholder="Email here!" class="w3-input w3-border" />
			</div>
            <div class="spacebetweeninput">
				<h5 style="font-family: 'Kreon', serif;">3th member's Email</h5>
				<input type="text" style="width:60%;" value="<?php echo $threeemail;?>" name="threeemail" placeholder="Email here!" class="w3-input w3-border" />
			</div>
			<div class="spacebetweeninput">
				<h5 style="font-family: 'Kreon', serif;">Contact Number</h5>
				<input type="text" style="width:60%;" value="<?php echo $contact_number;?>" name="contact_number" placeholder="Contact Number here!" required class="w3-input w3-border" />
				<span class="text-danger" style="color:red;"><?php if (isset($contact_error)) echo $contact_error; ?></span>
			</div>
			<br/>
			<div>
				<button class="btn btn-dark" name="signup" style="margin-right:20px;"> Register </button>
				<span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
				<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
			</div>
		</form>
        </div>
	</div>
	
</body>
</html>