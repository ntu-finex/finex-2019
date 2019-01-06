<?php
    include '../secure/connect.php';
    $email=mysqli_real_escape_string($connection,$_POST['email']);
    if(isset($_POST['pay'])){
        $query="SELECT * FROM finex_2018_registration WHERE email='".$email."'";
        $run=mysqli_query($connection,$query);
        $fetch=mysqli_fetch_array($run);
        $datetime = date_create("",timezone_open("Asia/Singapore"))->format('Y-m-d H:iP');
        $query2="INSERT INTO finex_paid(team_name,email,contact,payment_date) VALUES('".$fetch['teamname']. "', '".$fetch['email']. "', '".$fetch['contact_number'] . "',' ".$datetime. "')";
        if(mysqli_query($connection,$query2)){
            $successmsg="Successfully paid";
        }else{
            $successmsg="Fail";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Finex 2018 Payment</title>
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
			font-weight:normal;
		}
		.spacebetweeninput{
			margin-bottom:.5rem;
		}
		th{
			font-weight:normal;
		}
	</style>
</head>
<body>
	<?php include 'navbar.html'; ?>
	<br/><br/><br/>
    <div class="w3-container">
        <form class="w3-container" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="paymentform">
            <div style="margin-bottom:1rem;">
                <h5>Pay - Captain's email</h5>
                <select name="email">
                    <?php
                        $filter="SELECT email FROM finex_2018_registration";
                        $result=mysqli_query($connection,$filter);
                        while($row=mysqli_fetch_array($result)){
                    ?>
                    
                    <option><?php echo $row['email']; ?></option>
                    
                    <?php
                        }
                        mysqli_free_result($result);
                    ?>
                </select>
            </div>
            <div>
                <button class="btn btn-dark" name="pay" style="margin-right:2rem;"> Pay </button>
                <span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
            </div>
        </form>
    </div>
	<hr/>
	<div class="w3-container table-responsive">
		<h5 style="margin-bottom:1rem;">Registered</h5>
		<table class="table w3-centered">
			<thead class="thead-dark">
				<tr>
					<th>Group Name</th>
					<th>Captain's Email</th>
					<th>2nd person's Email</th>
					<th>3th person Email</th>
					<th>Phone Number</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query2="SELECT * FROM finex_2018_registration";
					$result=mysqli_query($connection,$query2);
					while($row=mysqli_fetch_assoc($result)){
				?>
				<tr>
					<th><?php echo $row['teamname']; ?></th>
					<th><?php echo $row['email']; ?></th>
					<th><?php echo $row['email2']; ?></th>
					<th><?php echo $row['email3']; ?></th>
					<th><?php echo $row['contact_number']; ?></th>
				</tr>
				<?php
					}
					//free result is not a neccesary code...
					mysqli_free_result($result); 
				?>
			</tbody>
		</table>
	</div>
	<hr/>
	<div class="w3-container table-responsive">
		<h5 style="margin-bottom:1rem;">Paid</h5>
		<table class="table w3-centered">
			<thead class="thead-dark">
				<tr>
					<th>Group Name</th>
					<th>Captain's Email</th>
					<th>Phone Number</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query2="SELECT * FROM finex_paid";
					$result=mysqli_query($connection,$query2);
					while($row=mysqli_fetch_assoc($result)){
				?>
				<tr>
					<th><?php echo $row['team_name']; ?></th>
					<th><?php echo $row['email']; ?></th>
					<th><?php echo $row['contact']; ?></th>
				</tr>
				<?php
					}
					//free result is not a neccesary code...
					mysqli_free_result($result); 
				?>
			</tbody>
		</table>
	</div>
</body>
</html>