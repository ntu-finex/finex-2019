<?php
	session_start();
	
	if(isset($_SESSION['teamname'])!=''){
		header("Location:index.php");
	}
	
	include_once 'connect.php';
	
	//check if form is submitted
	if(isset($_POST['login'])){
		
		$teamname = mysqli_real_escape_string($conn,$_POST['teamname']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);
        $result=mysqli_query($conn,"SELECT * FROM team WHERE teamname = '" . $teamname. "' and password = '" . $password . "'");
		if ($row = mysqli_fetch_array($result)){
			$_SESSION['teamname'] = $row['teamname'];
			header("Location: index.php");
		} else {
			$errormsg="Incorrect teamname or Password. Please try again.";
		}
    }
    include_once 'dc.php';
?>
<!DOCTYPE html>
<html>
    <?php
        include 'head.php';
    ?>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
        <span class="navbar-text">Finex</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
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
                            <label for="teamname">Teamname</label>
                            <input type="text" name="teamname" id="teamname" placeholder="Teamname" required autofocus class="form-control" />
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