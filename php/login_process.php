<?php

    $teamName = $password = "";

    if(isset($_POST['submit'])){
        try{
            $teamName = test_input($_POST["teamName"]);
            $password = test_input($_POST["password"]);

            $stmt = $conn->prepare("SELECT * FROM teams WHERE teamName=? AND password=?");
            $stmt->execute([$teamName,$password]);
            $team = $stmt->fetch();

            if($team){
                $_SESSION['teamName'] = $team['teamName'];

                header("Location: user_dashboard.php");
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
