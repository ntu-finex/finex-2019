<?php
	session_start();

	if(isset($_SESSION['station_name'])){
		$station_name = $_SESSION['station_name'];
        $name = $_SESSION['name'];
	}else{ 
		header('Location: gm_login.php');
	}

	include '../connect.php';
	
	if(isset($_POST['update'])){
        $query="SELECT * FROM team WHERE teamname='".$_POST['teamname']."'";
        $result=mysqli_query($conn,$query);
        if($row = mysqli_fetch_array($result)){
            $station_1 = $row['station_1'];
            $station_2 = $row['station_2'];
            $station_3 = $row['station_3'];
            $station_4 = $row['station_4'];
            $station_5 = $row['station_5'];
            $convert_point = $row['convert_point'];
        }
        switch ($station_name) {
            case 'station_1':
                $update_game_point = $_POST['point'] + $station_2 + $station_3 + $station_4 + $station_5;
                break;
            case 'station_2':
                $update_game_point = $_POST['point'] + $station_1 + $station_3 + $station_4 + $station_5;
                break;
            case 'station_3':
                $update_game_point = $_POST['point'] + $station_2 + $station_1 + $station_4 + $station_5;
                break;
            case 'station_4':
                $update_game_point = $_POST['point'] + $station_2 + $station_3 + $station_1 + $station_5;
                break;
            case 'station_5':
                $update_game_point = $_POST['point'] + $station_2 + $station_3 + $station_4 + $station_1;
                break;
            
        }
        $update_total = $update_game_point + $convert_point;
        $query1 = "UPDATE team SET ".$station_name."=".$_POST['point']." WHERE teamname='".$_POST['teamname']."'"; //update station point
        $query2 = "UPDATE team SET game_point=".$update_game_point." WHERE teamname='".$_POST['teamname']."'"; //update game point
        $query3 = "UPDATE team SET total_point=".$update_total." WHERE teamname='".$_POST['teamname']."'"; //update total point
		if(mysqli_query($conn,$query1) && mysqli_query($conn,$query2)&&mysqli_query($conn,$query3)){
			$succ_msg = "Update ".$_POST['teamname']." successfully.";
		}else{
			$fail_msg = "Update Fail";
		}
	}
?>
<!DOCTYPE html>
<html>
<?php
    include '../head.php';
?>
<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
        <span class="navbar-text">Finex-Game Master</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Logout</a>
                </li>
            </ul>
        </div>  
    </nav>
    <br/>
    <br/>
    <br/>
    <!--end of navbar-->
    <div class="container">
        <h3 style="color:#3399ff;" class="text-center">
            <?php
                echo $station_name." (".$name.")";
            ?>
        </h3>
        <hr/>
        <!--container for the form-->
        <div class="container">
            <div class="card mx-auto" style="width:25rem;">
                <div class="card-header text-center">
                    <h3>Update Form</h3>
                </div>
                <div class="card-body">
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="form-group">
                                <label for="teamname">Teamname</label>
                                <select class="custom-select" name="teamname" id="teamname">
                                    <option value="" selected></option>
                                    <?php
                                        $query="SELECT teamname,alias FROM team";
                                        $result=mysqli_query($conn,$query);
                                        while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo $row['teamname']; ?>"><?php echo $row['teamname']." (".$row['alias'].")"; ?></option>
                                    <?php
                                        }
                                        //free result is not a neccesary code...add syok je... 
                                        mysqli_free_result($result); 
							        ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="point">Points</label>
                                <input type="text" name="point" id="point" placeholder="Point" required class="form-control" onkeypress="return isNumberKey(event)"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="Update" class="btn btn-primary" />
                            </div>
                    </form>
                </div>
                <div class="card-footer">
                    <span class="text-danger"><?php if (isset($fail_msg)) { echo $fail_msg; } ?></span>
                    <span class="text-success"><?php if (isset($succ_msg)) { echo $succ_msg; } ?></span>
                </div>
            </div>
        </div>
</body>
</html>	
<?php
	mysqli_close($conn);
?>
