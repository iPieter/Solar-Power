<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Lato:100' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="../elements/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../elements/styles.css">

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
	echo "<h1>$date</h1>"
	include("analyse/graph.php");
	include("analyse/table.php");
	//$select = "SELECT * FROM sensor_values WHERE DATE(dtime) = '$date'";
}
else {
	//$select = "SELECT * FROM sensor_values";
}


?>

<script type="text/javascript">
//refresh the cache if clicked on a link
$('#cached').click(function() {

$.ajax({
url: 'analyse/recache.php', 
data: "date=" + '<?php echo $_GET['date'];?>', 
dataType: 'html',
success: function(data){
        $('#table_rapport').html(data);
        $('#cached').html('Cachegegevens net ververst');

      }
});
});
</script>
</body>