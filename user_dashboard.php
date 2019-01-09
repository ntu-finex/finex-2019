<?php
    session_start();
    
    include('inc/header.php');
    //require('secure/connect.php');
    if(isset($_SESSION['teamName']) == ""){
        header("Location: index.php");
    }
    
    require('classes/stock.php');

    define("STOCK1", 'Apple Inc');
    define("STOCK2", 'Tesla Inc');
    define("STOCK3", 'Microsoft Inc');
    define("STOCK4", 'Google Inc');

    //stats.php functions
    $teamName = $_SESSION['teamName'];
    $game_point = 0;
    $cash = 0;
    

    //stock.php functions
    $stocks = new Stock;
    $ownedStocks = $stocks->getStockByOwner($teamName);

    $Apple = $stocks->getCompanyStock(STOCK1);
    $Tesla = $stocks->getCompanyStock(STOCK2);
    $Google = $stocks->getCompanyStock(STOCK3);
    $Microsoft = $stocks->getCompanyStock(STOCK4);
    //get the difference between current price and previous price
    function getDifference($stock){
        return ($stock['current_price'] - $stock['previous_price']);
    }   
    
    function getPercentage($stock){
        $difference = getDifference($stock);
        $percentage = $difference/($stock['previous_price']) * 100;
        return round($percentage,2);
    }
?>
<script>
    $( document ).ready(getCash(), getPoints());

    function purchaseStock(){
        $.ajax({
            url:'php/stock_purchase.php',
            type: 'post',
            data:{
                id: 1,
                stockName: 'Apple Inc',
                owner: 'Apple Inc',
            },
            success:function(result){
                getCash();
            }
        });
    }

    function getCash(){
        $.ajax({
            url: 'php/stats.php',
            type: 'post',
            data:{
                choice: 1,
            },
            success:function(result){
                //console.log(result);
                $('#cash-result').html(result)
            }
        })
    }

    function getPoints(){
        $.ajax({
            url: 'php/stats.php',
            type: 'post',
            data:{
                choice: 2,
            },
            success:function(result){
                $('#points-result').html(result)
            }
        })
    }

    function showStocks($stockName){
        $.ajax({
            url: 'php/stock_show.php',
            type: 'GET',
            data:{
                name: $stockName,
            },
            dataType: 'json',
            success:function(result){
                //console.log(result);
                $.each(result, function(key, value) { //for each value in list will be in value
                    $("#STOCK1S").append('<div>' + value['owner'] + value['price'] + '</div>'); //I used the value as a specific item from list. 
                });
                $('#STOCK1S').removeAttr('id');
            }
        })
    }
</script>
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
                        <h4>$</h4><h3 id="cash-result"></h3>
                    </div>        
                </div>
            </div>
            <div class="col-md-6">
                <div id="gp_box">
                    <h5>Game Points</h5>
                    <div class="points">
                        <h3 id="points-result"></h3>
                    </div>       
                </div>
            </div>
        </div>
        <!-- Stocks' Market Price Area -->
        <div class="row" style="display:flex;">
            <div class="col-md-3">
                <!-- <button type="button" class="btn btn-primary" onclick="getPoints()">click me</button> -->
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock1" onclick="showStocks('<?php echo STOCK1 ?>')">
                    <h3><?php echo STOCK1 ?></h3>
                    <div class="stocks" >
                        <div style="text-align:right; <?php if((getDifference($Apple))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $Apple['current_price']?></h1>
                            <h6>
                            <?php if((getDifference($Apple))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                            <?php echo getDifference($Apple) ?>  (<?php echo getPercentage($Apple)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-body">
                    <h2 class="h2-responsive product-name">
                           <?php echo STOCK1 ?>
                    </h2>
                    <hr>
                    <div id="STOCK1S">
                      
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Purchase Stock
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock2" onclick="showStocks('<?php echo STOCK2 ?>')">
                    <h3><?php echo STOCK2 ?></h3>
                    <div class="stocks">
                        <div style="text-align:right; <?php if((getDifference($Tesla))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $Tesla['current_price']?></h1>
                            <h6><?php if((getDifference($Tesla))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?> $<?php echo getDifference($Tesla) ?>  (<?php echo getPercentage($Tesla)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                        <h2 class="h2-responsive product-name">
                            <strong><?php echo STOCK2?></strong>
                        </h2>
                        <hr>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary">Purchase Stock
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock3" onclick="showStocks('<?php echo STOCK3 ?>')">
                    <h3><?php echo STOCK3 ?></h3>
                    <div class="stocks">
                        <div style="text-align:right; <?php if((getDifference($Microsoft))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $Microsoft['current_price']?></h1>
                            <h6><?php if((getDifference($Microsoft))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?> $<?php echo getDifference($Microsoft) ?>  (<?php echo getPercentage($Microsoft)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-body">
                    <h2 class="h2-responsive product-name">
                            <strong><?php echo STOCK3 ?></strong>
                        </h2>
                        <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Purchase Stock
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock4" onclick="showStocks('<?php echo STOCK4 ?>')">
                    <h3><?php echo STOCK4 ?></h3>
                    <div class="stocks">
                        <div style="text-align:right; <?php if((getDifference($Google))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $Google['current_price']?></h1>
                            <h6><?php if((getDifference($Google))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?> $<?php echo getDifference($Google) ?>  (<?php echo getPercentage($Google)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-body">
                    <h2 class="h2-responsive product-name">
                            <strong><?php echo STOCK4 ?></strong>
                        </h2>
                        <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Purchase Stock
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </button>
                        </div>
                    </div>
                    </div>
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
   
   
</style>

