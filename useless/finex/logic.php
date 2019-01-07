<?php
    include 'connect.php';
    
    //update the scenario_id by using sequence
    $query = "SELECT number FROM utility WHERE name='current_sce'";
    $result = mysqli_query($conn,$query);
    $row = $result->fetch_assoc();
    $flip = $row['number'];
    if($flip<=30){
        $update = $flip + 30;
    }else{
        $update = $flip - 29;
    }
    $query = "UPDATE utility SET number ='".$update."' WHERE name ='current_sce'";
    if(mysqli_query($conn,$query)){
        echo 'update scenario -Successful';
    }else{
        echo 'update scenario -Fail';
    }
    echo "<br/>";

    //increment the question by 1 every certain minutes.
    $query = "SELECT number FROM utility WHERE name='current_ques'";
    $result = mysqli_query($conn,$query);
    $row = $result->fetch_assoc();
    $updated = ++$row['number'];
    $query = "UPDATE utility SET number ='".$updated."' WHERE name ='current_ques'";
    if(mysqli_query($conn,$query)){
        echo 'update question - Successful';
    }else{
        echo 'update question - Fail';
    }
    echo "<br/>";

    //alpha update
    $query = "SELECT * FROM utility_dec WHERE name='alpha'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $initial_alpha = $row['number'];
    
    $query = "SELECT * FROM utility WHERE name='current_sce'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $current_sce = $row['number'];
    
    //buy = point -> stock
    $query = "SELECT * FROM utility WHERE name='buy'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $buy = $row['number'];

    //sell = stock ->point
    $query = "SELECT * FROM utility WHERE name='sell'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $sell = $row['number'];

    $query = "SELECT * FROM scenario WHERE id='".$current_sce."'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $effect = $row['effect'];

    switch(TRUE){
        case in_array($buy, range(0,10000)):
            $buy_ct = 0.1;
            break;
        case in_array($buy, range(10001,20000)):
            $buy_ct = 0.12;
            break;
        case in_array($buy, range(20001,30000)):
            $buy_ct = 0.25;
            break;
        case in_array($buy, range(30001,40000)):
            $buy_ct = 0.38;
            break;
        case in_array($buy, range(40001,50000)):
            $buy_ct = 0.55;
            break;
        case in_array($buy, range(50001,60000)):
            $buy_ct = 0.78;
            break;
    }

    switch(TRUE){
        case in_array($sell, range(0,10000)):
            $sell_ct = 0.1;
            break;
        case in_array($sell, range(10001,20000)):
            $sell_ct = 0.12;
            break;
        case in_array($sell, range(20001,30000)):
            $sell_ct = 0.25;
            break;
        case in_array($sell, range(30001,40000)):
            $sell_ct = 0.38;
            break;
        case in_array($sell, range(40001,50000)):
            $sell_ct = 0.55;
            break;
        case in_array($sell, range(50001,60000)):
            $sell_ct = 0.78;
            break;
    }

    $ct = $buy_ct - $sell_ct;
    if($final_alpha = ($effect + $ct + 1) * $initial_alpha){
        echo "Calculate done<br/>Alpha = ".$final_alpha."<br/>";
    }
    $sell_alpha = $final_alpha * 1.1;
    $buy_alpha = $final_alpha * 0.95;

    $query1 = "UPDATE utility_dec SET number ='".$final_alpha."' WHERE name ='alpha'";
    $query2 = "UPDATE utility_dec SET number ='".$buy_alpha."' WHERE name ='buy_alpha'";
    $query3 = "UPDATE utility_dec SET number ='".$sell_alpha."' WHERE name ='sell_alpha'";
    if(mysqli_query($conn,$query1)&&mysqli_query($conn,$query2)&&mysqli_query($conn,$query3)){
        echo 'update alpha - Successful';
    }else{
        echo 'update alpha - Fail';
    }
?>