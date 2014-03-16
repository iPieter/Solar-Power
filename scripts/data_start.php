<?php

include('datalogin.php');

$sensor = $_GET['sensor'];

//check what type of sensor it is, and convert that to a string
if ($sensor == 1) {$sensorName = "Arduino Uno r3";}
elseif ($sensor == 2) {$sensorName = "Spark Core";}



//write everything in the database
$sql = "INSERT INTO groups (dtime, device) VALUES (NOW(), '$sensorName')";

mysqli_query($con, $sql);

mysqli_close($con);

?>