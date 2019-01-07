<?php
    require 'connect.php';
	$result=mysqli_query($conn,"SELECT * FROM team WHERE teamname= '" . $teamname . "'");
	if ($row = mysqli_fetch_array($result)){
		$station_1 = $row['station_1'];
		$station_2 = $row['station_2'];
		$station_3 = $row['station_3'];
		$station_4 = $row['station_4'];
        $station_5 = $row['station_5'];
        $answered = $row['answered'];
        $coin = $row['coin'];
        $total_point = $row['total_point'];
        $game_point = $row['game_point'];
        $convert = $row['convert_point'];
        $alias = $row['alias'];
    }
    $result=mysqli_query($conn,"SELECT * FROM utility_dec WHERE name='buy_alpha'");
	if ($row = mysqli_fetch_array($result)){
		$buy_rate = $row['number'];
    }
    $result=mysqli_query($conn,"SELECT * FROM utility_dec WHERE name='sell_alpha'");
	if ($row = mysqli_fetch_array($result)){
		$sell_rate = $row['number'];
    }
?>