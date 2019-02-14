<?php

session_start();
include('inc/admin_header.php');
include('secure/connect.php');
require('classes/stock.php');

  define("STOCK1", 'Apple Inc');
  define("STOCK2", 'Tesla Inc');
  define("STOCK3", 'Microsoft Inc');
  define("STOCK4", 'Google Inc');

  if(isset($_SESSION['station']) == ""){
      header("Location: admin_login.php");
  }

  $stationName = $_SESSION['station'];
  $stationNum = $_SESSION['stationNum'];

  $stocks = new Stock;
  $Apple = $stocks->getCompanyStock(STOCK1);
  $Tesla = $stocks->getCompanyStock(STOCK2);
  $Google = $stocks->getCompanyStock(STOCK4);
  $Microsoft = $stocks->getCompanyStock(STOCK3);

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
                  <div style="text-align:right; <?php if((getDifference($Apple))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $Apple['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($Apple))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($Apple) ?>  (<?php echo getPercentage($Apple)?>%)</h6>
                  </div>
              </div>
          </div>
          <hr>
          <div id="stocks_box" data-toggle="modal" data-target="#stock1">
              <h3><?php echo STOCK2 ?></h3>
              <div class="stocks" >
                  <div style="text-align:right; <?php if((getDifference($Tesla))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $Tesla['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($Tesla))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($Tesla) ?>  (<?php echo getPercentage($Tesla)?>%)</h6>
                  </div>
              </div>
          </div>
          <hr>
          <div id="stocks_box"  data-toggle="modal" data-target="#stock1">
              <h3><?php echo STOCK3 ?></h3>
              <div class="stocks" >
                  <div style="text-align:right; <?php if((getDifference($Google))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $Google['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($Google))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($Google) ?>  (<?php echo getPercentage($Google)?>%)</h6>
                  </div>
              </div>
          </div>
          <hr>
          <div id="stocks_box" data-toggle="modal" data-target="#stock1">
              <h3><?php echo STOCK4 ?></h3>
              <div class="stocks" >
                  <div style="text-align:right; <?php if((getDifference($Microsoft))>0) echo 'color:green'; else echo 'color:red'; ?>">
                      <h1>$<?php echo $Microsoft['current_price']?></h1>
                      <h6>
                      <?php if((getDifference($Microsoft))>0) echo '<i class="fa fa-caret-up" aria-hidden="true"></i>'; else echo '<i class="fa fa-caret-down" aria-hidden="true"></i>'; ?>$
                      <?php echo getDifference($Microsoft) ?>  (<?php echo getPercentage($Microsoft)?>%)</h6>
                  </div>
              </div>
          </div>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          
        </section>
    </div>
</body>
