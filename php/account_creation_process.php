<?php

    $teamName = $password = $captainEmail = $contactNumber = "";
    if(isset($_POST['submit'])){

        try{
             //clean the input variables
            $teamName = test_input($_POST["teamName"]);
            $captainEmail = test_input($_POST["captainEmail"]);
            $contactNumber = test_input($_POST["contactNumber"]);
            $password = test_input($_POST["password"]);

            $stmt = $conn->prepare("SELECT * FROM teams where teamName=?");
            $stmt->execute([$teamName]);

            if($stmt->rowCount() == 0){
                $sql = "INSERT INTO teams (teamName, captainEmail, contactNumber, password)
                    VALUES ('".$teamName."','".$captainEmail."','".$contactNumber."','".$password."')";

                if($conn->query($sql)){
                    echo '<script>alert("Account Created Successfully");</script>';
                }else{
                    echo '<script>alert("Account Created Unsuccessfully");</script>';
                }

                $sql = null;
            }else{
                echo '<script>alert("Account already exists in the database")</script>';
            }
             

        }catch(PDOEXCEPTION $e){
            echo '<script>alert("There are some errors with the system")</script>';//$e->getMessage();
        }
       
    }else{
        header('Location: account_creation.php');
        exit;
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>