<?php
	function replace_under($string) {
		$string = str_replace("_", " ", $string);
		return $string;
	}
	
	function replace_space($string) {
		$string = str_replace(" ", "_", $string);
		return $string;
	}
	
	function fetch_data($data){
		$sql1="SELECT * FROM description WHERE title='".$data."'";
		echo $sql1;
		if (mysqli_query($connection,$sql1)){
			echo 'true';
		}else{
			echo 'false';
		}
		$row1=mysqli_fetch_assoc($result1);
		$fetchdata=$row1["description"];
		echo $fetchdata;
	}
?>