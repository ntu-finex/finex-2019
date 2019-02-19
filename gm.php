<?php

session_start();
include('inc/admin_header.php');
include('secure/connect.php');
require('classes/stock.php');

  define("STOCK1", 'TEZLA INC');
  define("STOCK2", 'OSBS Bank');
  define("STOCK3", 'FINEX CO');
  define("STOCK4", 'NCF INC');

  if(isset($_SESSION['station']) == ""){
      header("Location: admin_login.php");
  }

  $stationName = $_SESSION['station'];
  $stationNum = $_SESSION['stationNum'];

  $stocks = new Stock;
  $Tezla = $stocks->getCompanyStock(STOCK1);
  $OSBSa = $stocks->getCompanyStock(STOCK2);
  $Finex = $stocks->getCompanyStock(STOCK3);
  $NCF = $stocks->getCompanyStock(STOCK4);

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
    <br>
    <div class="container">
        <section class="scenario">
          <h2 style="text-align:center;"><i><strong>Scenarios</strong></i></h2>
          <hr>
          <h3>Current Scenario</h3>
          <hr>


          <h3>Previous Scenario</h3>
          <hr>

        </section>
        <section class="stock_prices">
          <h2 style="text-align:center;"><i><strong>Stock Prices</strong></i></h2>
          <form action="php/setStockPrices.php" method="post" >
            <div class="form-group">
              <label for="sel1">Select stocks:</label>
              <select class="form-control" id="sel1" name="stockName">
                <option value="<?php echo STOCK1?>"><?php echo STOCK1?></option>
                <option value="<?php echo STOCK2?>"><?php echo STOCK2?></option>
                <option value="<?php echo STOCK3?>"><?php echo STOCK3?></option>
                <option value="<?php echo STOCK4?>"><?php echo STOCK4?></option>
              </select>
            </div>
            <input class="form-control group" type="number" step=".001" name="price" value="0">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
          </form>

          <hr>
          <div id="stocks_box" data-toggle="modal" data-target="#stock1">
              <h3><?php echo STOCK1 ?></h3>
              <div class="stocks" >
                  <div style="text-align:right; <?php if((getDifference($Tezla))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $Tezla['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($Tezla))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($Tezla) ?>  (<?php echo getPercentage($Tezla)?>%)</h6>
                  </div>
              </div>
          </div>
          <hr>
          <div id="stocks_box" data-toggle="modal" data-target="#stock1">
              <h3><?php echo STOCK2 ?></h3>
              <div class="stocks" >
                  <div style="text-align:right; <?php if((getDifference($OSBSa))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $OSBSa['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($OSBSa))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($OSBSa) ?>  (<?php echo getPercentage($OSBSa)?>%)</h6>
                  </div>
              </div>
          </div>
          <hr>
          <div id="stocks_box" data-toggle="modal" data-target="#stock1">
              <h3><?php echo STOCK3 ?></h3>
              <div class="stocks" >
                  <div style="text-align:right; <?php if((getDifference($Finex))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $Finex['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($Finex))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($Finex) ?>  (<?php echo getPercentage($Finex)?>%)</h6>
                  </div>
              </div>
          </div>
          <hr>
          <div id="stocks_box"  data-toggle="modal" data-target="#stock1">
              <h3><?php echo STOCK4 ?></h3>
              <div class="stocks" >
                  <div style="text-align:right; <?php if((getDifference($NCF))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $NCF['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($NCF))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($NCF) ?>  (<?php echo getPercentage($NCF)?>%)</h6>
                  </div>
              </div>
          </div>
          <hr>
          <div id='endGameDiv'>
            <button class="btn btn-danger btn-block" type="button" name="button" id="endGame">END THE GAME</button>
          </div>
          <br>
          <br>
          <br>
          <br>
          <br>
        </section>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
      $('#endGame').click(endGame);
    });

    function endGame(){
      if(!(confirm("Are you sure you want to end the game?"))){
        alert("Action is cancelled.");
        return false;
      }

      $.ajax({
        url: 'php/endGame.php',
        method: 'post',
        success: function(response){
          alert(response);
        }
      });
    }
</script>

<style media="screen">
  #endGame{
    background: red;
    color: white;
  }

</style>
