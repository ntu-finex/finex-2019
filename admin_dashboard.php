<?php

  session_start();
  include('inc/admin_header.php');
  include('secure/connect.php');
  if(isset($_SESSION['station']) == ""){
      header("Location: admin_login.php");
  }

  if(isset($_SESSION['station']) && $_SESSION['station'] == "GM"){
      header("Location: gm.php");
  }

  $stationName = $_SESSION['station'];
  $stationNum = $_SESSION['stationNum'];
?>
<script>
    $(document).ready(function(){

        //set the point function
        $('.btn-team').click(function(){
            var team = $(this).html();
            var station = $('.stationNum').html();
            setMark(team,station);
        });

        //filter team results
        $('.teamName').keyup(function(){
            var value = $(this).val().toLowerCase();
            $('.btn-team').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            })
        });
    });

    //ajax call
    function setMark(team,station){
        var mark = prompt("Enter the points for the team you've selected: " + team);

        if(mark == null || mark == ''){
            return false;
        }else if(mark < 0 || isNaN(mark)){
            alert("The value entered is invalid.");
            return false;
        }

        $.ajax({
            url: 'php/stats.php',
            method: 'post',
            data:{
                name: team,
                points: mark,
                station_num: station,
                choice: 3,
            },
            success:function(response){
                if(response == 1){
                    alert("Points for " + team + " has been successfully set to " + mark);
                }else{
                    alert("There's some error. Point is not set.");
                }
            }
        })
    }

</script>

<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <br>
        <h1 style="text-align:center;display:none;" class="stationNum"><?php echo $stationNum ?></h1>
        <h1 style="text-align:center;"><strong><?php echo $stationName ?></strong></h1>
        <hr>
        <input type="text" placeholder="Enter team name here" class="form-control group teamName">
        <br>
        <?php
            $query = $conn->prepare("SELECT * FROM teams ");
            $query->execute();
            $teams = $query->fetchAll();
            foreach($teams as $team){
                echo '<button class="btn btn-team">'.$team['teamName'].'</button>  ';
            }
        ?>
    </div>


</body>

<style>
    .btn-team{
        background: rgb(33, 68, 124);
        color: white;
        font-style: bold;
        font-size: 20px;
    }
</style>
