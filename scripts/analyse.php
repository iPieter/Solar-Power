<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Lato:100' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="../elements/bootstrap.css">

<title>Analyse</title>
</head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<body>

<?php
include('datalogin.php');

//get the date to analyse
if (!($_GET['date'] == null)) {
	$date = $_GET['date'];
	//$select = "SELECT * FROM sensor_values WHERE DATE(dtime) = '$date'";
}
else {
	//$select = "SELECT * FROM sensor_values";
}

include("analyse/graph.php");
include("analyse/table.php");
?>

</body>