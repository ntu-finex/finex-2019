<?php
    session_start();
    include('inc/header.php');
    //require('secure/connect.php');
    if(isset($_SESSION['teamName']) == ""){
        header("Location: index.php");
    }
    
    require('classes/stock.php');
    require('php/stats.php');

    //points.php functions
    $teamName = $_SESSION['teamName'];
    $game_point = getPoints($teamName)['game_points'];
    $cash = getCash($teamName)['cash'];

    //stock.php functions
    $stocks = new Stock;
    $ownedStocks = $stocks->getStockByOwner($teamName);
?>

<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>

<body>
    <div class="container">
        <br>
        <h1 class="text-center">Hello, <?php echo $_SESSION['teamName']?></h1>
        <hr>
        <div class="row">
            <div class="col-md-6" >
                <div id="cash_box">
                    <h5>💸Cash💸</h5>
                    <div class="cash">
                        <h4>$</h4><h3><?php echo $cash; ?></h3>
                    </div>        
                </div>
            </div>
            <div class="col-md-6">
                <div id="gp_box">
                    <h5>Game Points</h5>
                    <div class="points">
                        <h3><?php echo $game_point; ?></h3>
                    </div>       
                </div>
            </div>
        </div>
        <!-- Stocks on hand -->
        <div class="row" style="display:flex;">
            <div class="col-md-3">
                <div id="stocks_box">
                    <h3>Apple Inc</h3>
                    <div class="stocks" >
                        <div style="text-align:right; <?php if((-99-10)>0) echo 'color:red'; else echo 'color:green'; ?>">
                            <h1>$33.90</h1>
                            <h6><i class="fa fa-caret-up" aria-hidden="true"></i> $9.00 (10%)</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="stocks_box">
                    <h3>Tesla Inc</h3>
                    <div class="stocks">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="stocks_box">
                    <h3>Microsoft Inc</h3>
                    <div class="stocks">
                        <?php

                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="stocks_box">
                    <h3>Google Inc</h3>
                    <div class="stocks">
                        <?php

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    body{
        background: #f9fbff !important;
    }
   #cash_box,#gp_box{
       float: left;
       padding: 25px;
       border-width: 1px;
       width: 100%;
       margin-top: 20px;
       background: white;
       border-radius: 2px;
       box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
       height: 75%;
   }
   #stocks_box{
        float: left;
       padding: 25px;
       border-width: 1px;
       width: 100%;
       margin-top: 20px;
       background: white;
       border-radius: 2px;
       box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
       height: 75%;
       margin-bottom: 20px;
   }
   #cash_box h5, #gp_box h5{
       margin-top: -10px;
       color: rgb(102, 102, 102);
       text-align: center;
   }
   .cash,.points{
      text-align:center;
   }
   .cash h3,h4{
       display:inline;
   }
   #stocks_box h3{
       text-align:center;
       margin-top: -10px;
   }
   .stocks{

   }
</style>