<?php
$conn = mysqli_connect("localhost","ntu-i_root","a1a2a3","ntu-iic_database");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>