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
    $Google = $stocks->getCompanyStock(STOCK4);
    $Microsoft = $stocks->getCompanyStock(STOCK3);
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
    $(document).ready(function(){
        $('.sell-tab').hide();
        $('#stock1_sell,#stock2_sell,#stock3_sell,#stock4_sell').click(function(){
            $('.buy-tab').hide();
            $('.sell-tab').show();
        });
        $('#stock1_buy,#stock2_buy,#stock3_buy,#stock4_buy').click(function(){
            $('.buy-tab').show();
            $('.sell-tab').hide();
        });

        //sell_stock function
        $(".listit").click(function(e){
            var name = '';
            switch(e.target.id){
                case 'stock1_list': name = "Apple Inc"; break;
                case 'stock2_list': name = "Tesla Inc"; break;
                case 'stock3_list': name = "Microsoft Inc"; break;
                case 'stock4_list': name = "Google Inc"; break;
                default: break;
            }
            sellStock(name);
        });
    });

    function sellStock(stockName){
        $('form').each(function(){
            var validator = $(this).validate({
                errorPlacement: function(label, element) {
                    label.insertAfter(element);
                },
                rules:{
                    price:{
                        required: true,
                        number: true,
                        greaterThanZero: true,
                    },
                },
                messages:{
                    price:{
                        greaterThanZero: "Please enter a positive value."
                    }
                },
                submitHandler: function(form) {
                    $(form).ajaxSubmit({
                        url: 'php/stock_sell.php',
                        type: 'post',
                        data: {
                            name : stockName
                        },
                        success: function(result) { 
                            alert(result); 
                            showStocksOwned(stockName);
                        }
                    });
                }
            });
        });
    }

    function purchaseStock($id){
        if(!confirm("Are you sure you want to purchase this stock?")){
            return false;
        }
        $.ajax({
            url:'php/stock_purchase.php',
            type: 'post',
            data:{
                id: $id,
            },
            success:function(result){
                if(result === 'Stock is unavailable for purchase.' || result === "You don't have enough cash to purchase the stocks."){
                    alert(result);
                }else{
                    getCash();
                    alert("You have successfully purchase the stock!");
                    showStocks(result);
                }
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
                jQuery('#STOCK1S').empty();
                var counter = 0;
                $.each(result, function(key, value) { //for each value in list will be in value
                    counter++;
                    var name = value['name'];
                    var owner = value['owner'];
                    var id = value['id'];
                    $("#STOCK1S").append(
                        '<div style="border-style:dash">' + counter + '. ' + value['name'] + '<br>' + value['price'] + '<br>' + 
                        value['owner'] + '<button class="btn btn-primary" onclick="purchaseStock(\'' + id + '\')" style="padding:bottom:15px;float:right;">Purchase</button>' +'</div>' + '<hr>'
                        
                    ).hide().fadeIn(700); //Value as a specific item from list. 
                });
            }
        })
    }

    function showStocksOwned($stockName){
        $.ajax({
            url: 'php/stock_owned.php',
            type: 'GET',
            data:{
                name: $stockName,
            },
            dataType: 'json',
            success:function(result){
                jQuery('#stocks-owned').empty();
                $('#ownedQty').empty();
                var counter = 0;
                $('#ownedQty').append(result.length);
                $.each(result, function(key, value) { //for each value in list will be in value
                    counter++;
                    var name = value['name'];
                    var owner = value['owner'];
                    var id = value['id'];
                    var available = value['available'];
                    if(available == 1){
                        available = "Currently Listed for sale";
                    }else{
                        available = "Available for sale";
                    }
                    $("#stocks-owned").append(
                        '<div class="alert" style="background:grey;color:white;">' + counter + '. ' + value['name'] + '      ' + value['price'] + '<br>' + available + '<br>'+
                        '</div>' + '<hr>'
                        
                    ).hide().fadeIn(700); //Value as a specific item from list. 
                });
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
                <!-- <button type="button" class="btn btn-primary" onclick="purchaseStock()">click me</button> -->
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
                           <button class="btn btn-danger" id="stock1_sell" style="float:right;" onclick="showStocksOwned('<?php echo STOCK1 ?>')">Sell</button>
                           <button class="btn btn-primary" id="stock1_buy" style="float:right;margin-right:15px;">Buy</button>
                    </h2>
                    <hr>
                        <div class="buy-tab">
                            <div id="STOCK1S">
                            <!-- stock display area -->
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK1 ?>')">Refresh
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="sell-tab">
                            <form id="my-form1">
                            <i class="fa fa-money" aria-hidden="true"></i><input class="form-control group" name="price" placeholder="Enter your price">
                            <br>
                            <i class="fa fa-comment-o" aria-hidden="true"></i><input class="form-control group" name="description" placeholder="Describe your stock (optional)">
                            <br>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary listit" id="stock1_list">List It!</button>
                            </div>
                            </form>
                            <hr>
                            <div>
                                <h6>Currently owned <strong><?php echo STOCK1 ?></strong> stock: <span id="ownedQty"></span> </h6>
                                <br>
                                <div id="stocks-owned">
                                    
                                </div>
                            </div>
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
                            <button class="btn btn-danger" id="stock2_sell" style="float:right;">Sell</button>
                           <button class="btn btn-primary" id="stock2_buy" style="float:right;margin-right:15px;">Buy</button>
                        </h2>
                        <hr>
                        <div class="buy-tab">
                            <div id="STOCK1S">
                            <!-- stock display area -->
                            </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK2 ?>')">Refresh
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </div>
                        </div>
                        <div class="sell-tab">
                            <h6>Currently owned <strong><?php echo STOCK2 ?></strong> stock: 5 </h6>
                            <br>
                            <form id="my-form2">
                            <i class="fa fa-money" aria-hidden="true"></i><input class="form-control group" name="price" placeholder="Enter your price">
                            <br>
                            <i class="fa fa-comment-o" aria-hidden="true"></i><input class="form-control group" name="description" placeholder="Describe your stock (optional)">
                            <br>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary listit" id="stock2_list">List It!</button>
                            </div>
                            </form>
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
                                <button class="btn btn-danger" id="stock3_sell" style="float:right;">Sell</button>
                                <button class="btn btn-primary" id="stock3_buy" style="float:right;margin-right:15px;">Buy</button>
                            </h2>
                            <hr>
                            <div class="buy-tab">
                                <div id="STOCK1S">
                                <!-- stock display area -->
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK3 ?>')">Refresh
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="sell-tab">
                                <h6>Currently owned <strong><?php echo STOCK3 ?></strong> stock: 5 </h6>
                                <br>
                                <form id="my-form3">
                                <i class="fa fa-money" aria-hidden="true"></i><input class="form-control group" name="price" placeholder="Enter your price">
                                <br>
                                <i class="fa fa-comment-o" aria-hidden="true"></i><input class="form-control group" name="description" placeholder="Describe your stock (optional)">
                                <br>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary listit" id="stock3_list">List It!</button>
                                </div>
                                </form>
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
                            <button class="btn btn-danger" id="stock4_sell" style="float:right;">Sell</button>
                            <button class="btn btn-primary" id="stock4_buy" style="float:right;margin-right:15px;">Buy</button>
                        </h2>
                        <hr>
                        <div class="buy-tab">
                            <div id="STOCK1S">
                            <!-- stock display area -->
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK4 ?>')">Refresh
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="sell-tab">
                            <h6>Currently owned <strong><?php echo STOCK4 ?></strong> stock: 5 </h6>
                            <br>
                            <form id="my-form4">
                            <i class="fa fa-money" aria-hidden="true"></i><input class="form-control group" name="price" placeholder="Enter your price">
                            <br>
                            <i class="fa fa-comment-o" aria-hidden="true"></i><input class="form-control group" name="description" placeholder="Describe your stock (optional)">
                            <br>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary listit" id="stock4_list">List It!</button>
                            </div>
                            </form>
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
    label.error {
        height:17px;
        padding:1px 5px 0px 5px;
        color: red;
    }
</style>

<script>
    jQuery.validator.addMethod("greaterThanZero", function(value) {
        return (parseFloat(value) >= 0);
    }); // Amount must be greater than zero");
</script>