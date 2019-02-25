<?php
include 'connect.php';
$result=mysqli_query($conn,"SELECT * FROM utility_dec WHERE name='buy_alpha'");
if ($row = mysqli_fetch_array($result)){
    $buy_rate = $row['number'];
}
$query = "SELECT * FROM team";
$result=mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($result)){
    $teamname = $row['teamname'];
    $buy = $row['coin'];
    $coin = $row['coin'];
    $total_point = $row['total_point'];
    $game_point = $row['game_point'];
    $convert = $row['convert_point'];
    $amount = $buy * $buy_rate;
    $update = $convert + $amount;
    $update_total = $game_point + $update;
    $update_coin = $coin - $buy;
    
    $query1 = "UPDATE team SET convert_point =".$update." WHERE teamname ='".$teamname."'";
    $query2 = "UPDATE team SET total_point =".$update_total." WHERE teamname ='".$teamname."'";
    $query3 = "UPDATE team SET coin =".$update_coin." WHERE teamname ='".$teamname."'";
    mysqli_query($conn,$query1);
    mysqli_query($conn,$query2);
    mysqli_query($conn,$query3);
}
mysqli_free_result($result); 
?>