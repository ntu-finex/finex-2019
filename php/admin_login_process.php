<?php

    $stationNum = $station = $password = "";
    

    if(isset($_POST['submit'])){
        try{
            $station = test_input($_POST["station"]);
            $password = test_input($_POST["password"]);
            
            $stmt = $conn->prepare("SELECT * FROM stations WHERE station_name=? AND password=?");
            $stmt->execute([$station,$password]); 
            $team = $stmt->fetch();

            if($team){
                $_SESSION['station'] = $team['name'];
                $_SESSION['stationNum'] = $team['station_name'];

                header("Location: admin_dashboard.php");
            }else{
                echo "<script>alert('Invalid Credentials')</script>";
            }
        }catch(PDOEXCEPTION $e){
            echo $e->getMessage();
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>