<?php
//connect to mysql database
$con = mysqli_connect("localhost", "root", "", "table_name") or die("Error " . mysqli_error($con));
date_default_timezone_set('Asia/Kolkata');
$timeNow = date("Y-m-d H:i:s");
?>