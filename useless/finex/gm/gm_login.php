<?php
	session_start();
	
	if(isset($_SESSION['station_name'])!=''){
		header("Location:gm_index.php");
	}
	
	include_once '../connect.php';
	
	//check if form is submitted
	if(isset($_POST['login'])){
		
		$station_name = mysqli_real_escape_string($conn,$_POST['station_name']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);
        $result=mysqli_query($conn,"SELECT * FROM stations WHERE station_name = '" . $station_name. "' and password = '" . $password . "'");
		if ($row = mysqli_fetch_array($result)){
			$_SESSION['station_name'] = $row['station_name'];
            $_SESSION['name'] = $row['name'];
			header("Location: gm_index.php");
		} else {
			$errormsg="Incorrect ID or Password. Please try again.";
		}
    }
    include_once '../dc.php';
?>
<!DOCTYPE html>
<html>
    <?php
        include '../head.php';
    ?>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
        <span class="navbar-text">Finex-Game Master</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="gm_login.php">Login</a>
                </li>
            </ul>
        </div>  
    </nav>
    <br/>
    <br/>
    <br/>
    <!--end of navbar-->
    <!--container for the form-->
	<div class="container">
        <div class="card mx-auto" style="width:25rem;">
            <div class="card-header text-center">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                        <div class="form-group">
                            <label for="name">Station Name</label>
                            <input type="text" name="station_name" id="name" placeholder="Station Name" required autofocus class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" required class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" value="Login" class="btn btn-primary" />
                        </div>
                </form>
            </div>
            <div class="card-footer">
                <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
            </div>
        </div>
	</div>
    <!-- end of container of the form-->
</body>
</html>