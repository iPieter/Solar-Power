<?php

include('datalogin.php');

$sensor = $_GET['sensor'];

//check what type of sensor it is, and convert that to a string
if ($sensor == 1) {$sensorName = "Arduino Uno r3";}



//write everything in the database
$sql = "INSERT INTO groups (dtime, device) VALUES (NOW(), '$sensorName')";

mysqli_query($con, $sql);
echo $sql;
mysqli_close($con);

?>