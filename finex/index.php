<?php
    session_start();
    
	if(isset($_SESSION['teamname'])){
        $teamname=$_SESSION['teamname'];
    }else{
        header('Location: login.php');
    }

    include 'point.php';
	$sell = mysqli_real_escape_string($conn,$_POST['sell']);
    $amount = $sell * $sell_rate;
    if(isset($_POST['sell_convert'])&&($total_point>=$amount)){
        $update = $convert - $amount;
        $update_total = $game_point + $update;
        $update_coin = $coin + $sell;
        $query1 = "UPDATE team SET convert_point =".$update." WHERE teamname ='".$teamname."'";
        $query2 = "UPDATE team SET total_point =".$update_total." WHERE teamname ='".$teamname."'";
        $query3 = "UPDATE team SET coin =".$update_coin." WHERE teamname ='".$teamname."'";
        if(mysqli_query($conn,$query1)&&mysqli_query($conn,$query2)&&mysqli_query($conn,$query3)){
            $_SESSION['message'] = "You have bought ".$sell." unit(s).";
        }else{
            $_SESSION['message'] = "Transaction fail. You don't have enough points";
        }
        echo "<script> location.replace('index.php'); </script>";
    }

    if(isset($_POST['buy_convert'])&&($coin>=$_POST['buy'])){
        $buy = mysqli_real_escape_string($conn,$_POST['buy']);
        $amount = $buy * $buy_rate;
        $update = $convert + $amount;
        $update_total = $game_point + $update;
        $update_coin = $coin - $buy;
        $query1 = "UPDATE team SET convert_point =".$update." WHERE teamname ='".$teamname."'";
        $query2 = "UPDATE team SET total_point =".$update_total." WHERE teamname ='".$teamname."'";
        $query3 = "UPDATE team SET coin =".$update_coin." WHERE teamname ='".$teamname."'";
        if(mysqli_query($conn,$query1)&&mysqli_query($conn,$query2)&&mysqli_query($conn,$query3)){
            $_SESSION['message'] = "You have sold ".$buy." unit(s).";
        }else{
            $_SESSION['message'] = "Transaction fail. You don't have enough stocks";
        }
        echo "<script> location.replace('index.php'); </script>";
    }
?>
<!DOCTYPE html>
<html>
<?php
    include 'head.php';
?>
<style>
    .btm-line{
        border-bottom-style: solid;
    }
    .btm-margin{
        margin-bottom:2rem;
    }
    a:link {
        color: black;
    }
    a:visited {
        color: black;
    }
</style>
<body>
	<?php
		include 'header.php';
	?>
    <br/>
    <br/>
    <br/>
	<div class="container text-center">
        <h3 style="color:#3399ff;">
            <?php
                echo $teamname." (".$alias.")";
            ?>
        </h3>
		<h3>The marketplace has stopped working. Please come back to Great Eastern Center ASAP!</h3>
        <span class="text-info"><?php echo "Last activity: ".$_SESSION['message']; ?></span><br/>
		<span class="text-info">For your information, at the end of the games, the total points earned by each team will determine your final score. The final score will determine your overall ranking. The system will convert the remaining of stock units in your account into points based on the ratio at that moment.</span>
        <hr/>
        <div class="card mx-auto" style="width:80%">
            <div class="card-body row">
                <div class="col-sm" style="margin-bottom:1rem;">
                    <h3 class="btm-line">Point</h3>
                    <h3>
                        <?php
                            echo $total_point;
                        ?>
                    </h3>
                </div>
                <div class="col-sm" style="margin-bottom:1rem;">
                    <a class="btn btn-light" data-toggle="modal" data-target="#converter" style="border:solid; border-color:#61666b;">
                        <img src="img/change.png" alt="convert" width="50">
                    </a>
                </div>
                <div class="col-sm">
                    <h3 class="btm-line">Finex.co share (unit)</h3>
                    <h3>
                        <?php
                            echo $coin;
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <br/>
        <div class="card mx-auto" style="width:80%;">
            <div class="card-header">
                <h3>Station games</h3>
            </div>
            <br/>
            <div class="card-body">
                <div style="width:85%" class="mx-auto btm-margin">
                    <h3 class="btm-line" style="color:#3399ff;">Game Points</h3>
                    <h3>
                        <?php
                            echo "<h3>".$game_point."</h3>";
                        ?>
                    </h3>
                </div>
                <div style="width:70%" class="mx-auto btm-margin">
                    <h4 class="btm-line">
                        <?php
                            if($station_5 != 0||$station_1!=0){
                                echo "<a href='Carnival.php'>Carnival Game station</a>";
                            }else{
                                echo "Carnival Game station";
                            }
                        ?>
                    </h4>
                    <h3>
                        <?php
                            echo $station_1;
                        ?>
                    </h3>
                </div>
                <div style="width:70%" class="mx-auto btm-margin">
                    <h4 class="btm-line">
                        <?php
                            if($station_1 != 0||$station_2!=0){
                                echo "<a href='race.php'>Race through life</a>";
                            }else{
                                echo "Race through life";
                            }
                        ?>
                    </h4>
                    <h3>
                        <?php
                            echo $station_2;
                        ?>
                    </h3>
                </div>
                <div style="width:70%" class="mx-auto btm-margin">
                    <h4 class="btm-line">
                        <?php
                            if($station_2 != 0||$station_3!=0){
                                echo "<a href='finexyear.php'>Spend Wisely!</a>";
                            }else{
                                echo "Spend Wisely!";
                            }
                        ?>
                    </h4>
                    <h3>
                        <?php
                            echo $station_3;
                        ?>
                    </h3>
                </div>
                <div style="width:70%" class="mx-auto btm-margin">
                    <h4 class="btm-line">
                        <?php
                            if($station_3 != 0||$station_4!=0){
                                echo "<a href='go.php'>Go Premium or Go Normal</a>";
                            }else{
                                echo "Go Premium or Go Normal";
                            }
                        ?>
                    </h4>
                    <h3>
                        <?php
                            echo $station_4;
                        ?>
                    </h3>
                </div>
                <div style="width:70%" class="mx-auto">
                    <h4 class="btm-line">
                        <?php
                            if($station_4 != 0||$station_5!=0){
                                echo "<a href='upanddown.php'>Up and down</a>";
                            }else{
                                echo "Up and down";
                            }
                        ?>
                    </h4>
                    <h3>
                        <?php
                            echo $station_5;
                        ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div>
    <!--open for extension-->
    <?php
        include 'question.php';
    ?>
    </div>
    <br/>
    <!-- Modal -->
    <div class="modal fade" id="converter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right:0px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buy/Sell</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h4><b>Scenario</b></h4>
                            <p>
                                <?php 
                                    $result=mysqli_query($conn,"SELECT * FROM utility WHERE name='current_sce'");
                                    if ($row = mysqli_fetch_array($result)){
                                        $current_sce = $row['number'];
                                    }
                                    $result = mysqli_query($conn,"SELECT * FROM scenario WHERE id='".$current_sce."'");
                                    if ($row = mysqli_fetch_array($result)){
                                        $description = $row['description']; 
                                        echo $description;
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                    <br/>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="btm-line text-center">Finex.co share --> Point</h4>
                            <h5 style="color:grey;">Rate : <?php echo "<b style='color:black;'>".$buy_rate."</b> point per unit"; ?></h5>
                            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="buy_form">
                                <div class="input-group mb-3" style="width:70%">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Share unit</span>
                                    </div>
                                    <input type="text" name="buy" id="buy_input" class="form-control" aria-label="Coin Amount" onkeypress="return isNumberKey(event)" onchange="buy_total()" placeholder="Amount">
                                </div>
                                <div id="buy_total"></div><br/>
                                <input type="submit" name="buy_convert" value="Convert" class="btn btn-primary" />
                            </form>
                        </div>
                    </div>
                    <br/>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="btm-line text-center">Point --> Finex.co share</h4>
                            <h5 style="color:grey;">Rate : <?php echo "<b style='color:black;'>".$sell_rate."</b> point per unit"; ?></h5>
                            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="sell_form">
                                <div class="input-group mb-3" style="width:70%">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Share unit</span>
                                    </div>
                                    <input type="text" name="sell" id="sell_input" class="form-control" aria-label="Coin Amount" onkeypress="return isNumberKey(event)" onchange="sell_total()" placeholder="Amount">
                                </div>
                                <div id="sell_total"></div><br/>
                                <input type="submit" name="sell_convert" value="Convert" class="btn btn-primary" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode < 48 || charCode > 57)){
            return false;
        } 
        return true;
    }
    function buy(){
        //Assume form with id="theform"
        var theForm = document.forms["buy_form"];
        //Get a reference to the TextBox
        var quantity = theForm.elements["buy_input"];
        var howmany =0;
        //If the textbox is not blank
        if(quantity.value!="")
        {
            howmany = parseInt(quantity.value);
        }     
    return howmany;
    }
    function buy_total(){
    //Here we get the total price by calling our function
    //Each function returns a number so by calling them we add the values they return together
    var buy_total = buy() *<?php echo $buy_rate; ?>;
    //display the result
    document.getElementById('buy_total').innerHTML = "Total points: "+ buy_total;
    }

    function sell(){
        //Assume form with id="theform"
        var theForm = document.forms["sell_form"];
        //Get a reference to the TextBox
        var quantity = theForm.elements["sell_input"];
        var howmany =0;
        //If the textbox is not blank
        if(quantity.value!="")
        {
            howmany = parseInt(quantity.value);
        }
        
    return howmany;
    }
    function sell_total(){
    //Here we get the total price by calling our function
    //Each function returns a number so by calling them we add the values they return together
    var sell_total = sell() *<?php echo $sell_rate; ?>;
    //display the result
    document.getElementById('sell_total').innerHTML = "Total points: "+ sell_total;
    }

    </script>
</body>
</html>