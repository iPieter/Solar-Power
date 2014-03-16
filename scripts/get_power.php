<?php
include("datalogin.php");

$result = mysqli_query($con,"SELECT * FROM sensor_values ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_array($result);

echo json_encode($row);

?>