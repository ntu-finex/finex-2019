<?php
    session_start();
    include('inc/header.php');
    require('secure/connect.php');
    if(isset($_SESSION['teamName']) == ""){
        header("Location: index.php");
    }
    include('classes/stock.php');
?>

<head>
    <title>User Dashboard</title>
</head>

<body>
    <div class="container">
        <br>
        <h1 class="text-center">Hello, <?php echo $_SESSION['teamName']?></h1>
        <hr>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4" >
                <div id="cash_box">
                    <h5>💸Cash💸</h5>
                    <div class="cash">
                        <h4>$</h4><h3>123</h3>
                    </div>        
                </div>
            </div>
            <div class="col-md-4">
                <div id="gp_box">
                    <h5>Game Points</h5>
                    <div class="points">
                        <h3>12031230</h3>
                    </div>       
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php
            $stock = new Stock;
            print_r($stock->getStockByOwner($_SESSION['teamName']));
        ?>
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

</style>