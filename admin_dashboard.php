<?php

  session_start();
  include('inc/admin_header.php');
  include('secure/connect.php');
  if(isset($_SESSION['station']) == ""){
      header("Location: admin_login.php");
  }

  else if(isset($_SESSION['station']) && $_SESSION['station'] == "GM"){
      header("Location: gm.php");
  }

  $stationName = $_SESSION['station'];
  $stationNum = $_SESSION['stationNum'];
?>
<script>
    $(document).ready(function(){
        var team = "";
        var station = "";
        //set the point function
        $('.btn-team').click(function(){
             team = $(this).html();
            $('.modal-title').html(team);
             station = $('.stationNum').html();
            //setMark(team,station,marks);
        });

        //filter team results
        $('.teamName').keyup(function(){
            var value = $(this).val().toLowerCase();
            $('.btn-team').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            })
        });

        $('.container').on('click', '#setPoints', function(){

            var points = $( "#points option:selected" ).text();
            setMark(team,station,points);
        });
    });



    //ajax call
    function setMark(team,station,mark){

        if(mark == null || mark == '' ||  mark == 0){
            alert("The value entered is invalid.");
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
        <br>
        <p style="color:red;">Search for the team name and click the button to enter their points.</p>
        <hr>
        <input type="text" placeholder="Search for team name here" class="form-control group teamName">
        <br>
        <?php
            $query = $conn->prepare("SELECT * FROM teams ");
            $query->execute();
            $teams = $query->fetchAll();
            foreach($teams as $team){
                echo '<button class="btn btn-team" data-toggle="modal" data-target="#exampleModal">'.$team['teamName'].'</button>  ';
            }
        ?>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h6>Enter the points here:<h6>
                <select class="form-control" name="points" id="points">
                  <option value="">0</option>
                  <option value="5000">5000</option>
                  <option value="4000">4000</option>
                  <option value="3000">3000</option>
                  <option value="2000">2000</option>
                  <option value="1000">1000</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="setPoints">Set Points</button>
              </div>
            </div>
          </div>
        </div>
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
