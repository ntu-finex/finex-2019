<?php
    session_start();

    include('inc/header.php');
    //require('secure/connect.php');
    if(isset($_SESSION['teamName']) == ""){
        header("Location: index.php");
    }

    require('classes/stock.php');

    define("STOCK1", 'TEZLA INC');
    define("STOCK2", 'OSBS Bank');
    define("STOCK3", 'FINEX CO');
    define("STOCK4", 'NCF INC');

    //stats.php functions
    $teamName = $_SESSION['teamName'];
    $game_point = 0;
    $cash = 0;
    $servername = DB_HOST;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $conn = new PDO("mysql:host=$servername;dbname=ntu-iic_database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //stock.php functions
    $stocks = new Stock;
    $ownedStocks = $stocks->getStockByOwner($teamName);

    $Tezla = $stocks->getCompanyStock(STOCK1);
    $OSBS = $stocks->getCompanyStock(STOCK2);
    $NCF = $stocks->getCompanyStock(STOCK4);
    $Finex = $stocks->getCompanyStock(STOCK3);
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

<head>
    <title>User Dashboard</title>
    <meta http-equiv="refresh" content="240">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="js/functions.js?newversion"></script>
</head>

<body>
    <div class="wrapper container">
        <br>
        <h3><strong><?php echo $_SESSION['teamName']?></strong></h3>
        <hr>
        <h3 style="text-align:center;"><strong>Latest News</strong></h3>
        <article class="scenario">
          <?php
          require_once('secure/config.php');

            $sql = $conn->prepare("SELECT * FROM utility WHERE name='current_sce'");
            $sql->execute();
            $current_sce = $sql->fetch()['number'];
            $stmt = $conn->prepare("SELECT * FROM scenarios WHERE id=?");
            $stmt->execute([$current_sce]);
            $scenario = $stmt->fetch();
            echo $scenario['description'];
            $query = $conn->prepare("SELECT * FROM utility WHERE name='button_disabled'");
            $query->execute();
            $disable = $query->fetch()['number'];
          ?>

        </article>
        <div class="row">
            <div class="col-md" >
                <div id="cash_box">
                    <h5>💸<strong>Cash</strong>💸</h5>
                    <div class="cash">
                        <h4>$</h4><h3 id="cash-result"></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stocks' Market Price Area -->
        <div class="row" style="display:flex;">
            <div class="col-md-3">
                <!-- <button type="button" class="btn btn-primary" onclick="purchaseStock()">click me</button> -->
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock1" onclick="showStocks('<?php echo STOCK1 ?>');showMultipleStocks('<?php echo STOCK1 ?>');" <?php if($disable==1) echo 'disabled'?>>
                    <h3><?php echo STOCK1 ?></h3>
                    <div class="stocks" >
                        <div style="text-align:right; <?php if((getDifference($Tezla))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $Tezla['current_price']?></h1>
                            <h6>
                            <?php if((getDifference($Tezla))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                            <?php echo getDifference($Tezla) ?>  (<?php echo getPercentage($Tezla)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-body">
                    <h3 class="h2-responsive product-name">
                           <?php echo STOCK1 ?>
                           <button class="btn btn-danger" id="stock1_sell" style="float:right;" onclick="showMultipleStocks('<?php echo STOCK1 ?>')">Sell</button>
                           <button class="btn btn-primary" id="stock1_buy" style="float:right;margin-right:15px;" onclick="showStocks('<?php echo STOCK1 ?>');">Buy</button>
                    </h3>
                    <hr>
                        <div class="buy-tab">
                            <div class="container">
                                <div class="STOCK2S" style="text-align: center;margin:0 auto;"></div>
                                <br>
                                <div class="STOCK1S row" style="text-align: center;margin:0 auto;"><!-- stock display area --></div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK1 ?>')">Refresh
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="sell-tab">
                            <div>
                                <h6>Currently owned <strong><?php echo STOCK1 ?></strong> stock: <span class="ownedQty"></span> </h6>
                                <br>
                                <div class="stocks-owned">

                                </div>
                                <!-- <div class='btn btn-primary companyStock'><br><span class='price'></span ><br>available<span class='quantity'></span><br><div class="input-group"><span class="input-group-btn"><button class="btn btn-white btn-minuse" type="button">-</button></span><input type="number" class="form-control no-padding add-color text-center height-25" maxlength="3" value="0"><span class="input-group-btn"><button class="btn btn-red btn-pluss" type="button"></button></span></div><button class='btn btn-success btn-purchase' onclick='purchaseCompanyStock($stockName)'>Purchase</button></div><br> -->
                                <hr>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" onclick="showMultipleStocks('<?php echo STOCK1 ?>')">Refresh
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock2" onclick="showStocks('<?php echo STOCK2 ?>');showMultipleStocks('<?php echo STOCK2 ?>')" <?php if($disable==1) echo 'disabled'?>>
                    <h3><?php echo STOCK2 ?></h3>
                    <div class="stocks">
                        <div style="text-align:right; <?php if((getDifference($OSBS))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $OSBS['current_price']?></h1>
                            <h6><?php if((getDifference($OSBS))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?> $<?php echo getDifference($OSBS) ?>  (<?php echo getPercentage($OSBS)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                        <h3 class="h2-responsive product-name">
                            <strong><?php echo STOCK2?></strong>
                            <button class="btn btn-danger" id="stock2_sell" style="float:right;" onclick="showMultipleStocks('<?php echo STOCK2 ?>')">Sell</button>
                           <button class="btn btn-primary" id="stock2_buy" style="float:right;margin-right:15px;" onclick="showStocks('<?php echo STOCK2 ?>');">Buy</button>
                        </h3>
                        <hr>
                        <div class="buy-tab">
                            <div class="container">
                                <div class="STOCK2S" style="text-align: center;margin:0 auto;"></div>
                                <br>
                                <div class="STOCK1S row" style="text-align: center;margin:0 auto;"><!-- stock display area --></div>
                            </div>
                            <hr>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK2 ?>')">Refresh
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </div>
                        </div>
                        <div class="sell-tab">
                            <div>
                                <h6>Currently owned <strong><?php echo STOCK2 ?></strong> stock: <span class="ownedQty"></span> </h6>
                                <br>
                                <div class="stocks-owned">

                                </div>
                                <hr>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" onclick="showMultipleStocks('<?php echo STOCK2 ?>')">Refresh
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock3" onclick="showStocks('<?php echo STOCK3 ?>');showMultipleStocks('<?php echo STOCK3 ?>');" <?php if($disable==1) echo 'disabled'?>>
                    <h3><?php echo STOCK3 ?></h3>
                    <div class="stocks">
                        <div style="text-align:right; <?php if((getDifference($Finex))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $Finex['current_price']?></h1>
                            <h6><?php if((getDifference($Finex))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?> $<?php echo getDifference($Finex) ?>  (<?php echo getPercentage($Finex)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                        <h3 class="h2-responsive product-name">
                                <strong><?php echo STOCK3 ?></strong>
                                <button class="btn btn-danger" id="stock3_sell" style="float:right;" onclick="showMultipleStocks('<?php echo STOCK3 ?>')">Sell</button>
                                <button class="btn btn-primary" id="stock3_buy" style="float:right;margin-right:15px;" onclick="showStocks('<?php echo STOCK3 ?>');">Buy</button>
                            </h3>
                            <hr>
                            <div class="buy-tab">
                                <div class="container">
                                    <div class="STOCK2S" style="text-align: center;margin:0 auto;"></div>
                                    <br>
                                    <div class="STOCK1S row" style="text-align: center;margin:0 auto;"><!-- stock display area --></div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK3 ?>')">Refresh
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="sell-tab">
                                <div>
                                    <h6>Currently owned <strong><?php echo STOCK3 ?></strong> stock: <span class="ownedQty"></span> </h6>
                                    <br>
                                    <div class="stocks-owned">

                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" onclick="showMultipleStocks('<?php echo STOCK3 ?>')">Refresh
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <button id="stocks_box" type="button" data-toggle="modal" data-target="#stock4" onclick="showStocks('<?php echo STOCK4 ?>');showMultipleStocks('<?php echo STOCK4 ?>')" <?php if($disable==1) echo 'disabled'?>>
                    <h3><?php echo STOCK4 ?></h3>
                    <div class="stocks">
                        <div style="text-align:right; <?php if((getDifference($NCF))>0) echo 'color:green'; else echo 'color:red'; ?>">
                            <h1>$<?php echo $NCF['current_price']?></h1>
                            <h6><?php if((getDifference($NCF))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?> $<?php echo getDifference($NCF) ?>  (<?php echo getPercentage($NCF)?>%)</h6>
                        </div>
                    </div>
                </button>
                <!-- Modal: modalQuickView -->
                <div class="modal fade" id="stock4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-body">
                    <h3 class="h2-responsive product-name">
                            <strong><?php echo STOCK4 ?></strong>
                            <button class="btn btn-danger" id="stock4_sell" style="float:right;" onclick="showMultipleStocks('<?php echo STOCK4 ?>')">Sell</button>
                            <button class="btn btn-primary" id="stock4_buy" style="float:right;margin-right:15px;" onclick="showStocks('<?php echo STOCK4 ?>');">Buy</button>
                        </h3>
                        <hr>
                        <div class="buy-tab">
                            <div class="container">
                                <div class="STOCK2S" style="text-align: center;margin:0 auto;"></div>
                                <br>
                                <div class="STOCK1S row" style="text-align: center;margin:0 auto;"><!-- stock display area --></div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" onclick="showStocks('<?php echo STOCK4 ?>')">Refresh
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="sell-tab">
                            <div>
                                <h6>Currently owned <strong><?php echo STOCK4 ?></strong> stock: <span class="ownedQty"></span> </h6>
                                <br>
                                <div class="stocks-owned">

                                </div>
                                <hr>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" onclick="showMultipleStocks('<?php echo STOCK4 ?>')">Refresh
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
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
    .scenario{
      text-align: center;
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
    .stocks_box{
        border-radius: 15px;
        /* box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); */
        background: rgb(247, 249, 248);
        width: 48%;
    }
    .stocks_box:active{
        top: 3px;
        box-shadow: 0 2px 0 #0b5ea3;
    }

  .companyStock,.multipleStock{
      border-radius: 15px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
      background: rgb(247, 249, 248);
      width: 100%
  }


  /*This disables the double tap to zoom on mobile devices*/
  button {
      touch-action: manipulation;
  }

</style>
