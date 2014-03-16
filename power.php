<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300|Lato:100' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="elements/power.css">

<title>Power</title>
</head>

<body>

<div id="background">
<?php
include("elements/background.php");
?>
</div>

<div id="text">
<?php
 if (strpos($rand_image, 'b_')) {
	echo("<h1 style='color: #ededed;' id='power'>1.23 W</h1>");
 }
 else {
	echo("<h1 style='color: #2f2f2f;' id='power'>1.23 W</h1>");

 }
?>
	
</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(window).load(refresh());

var tid = setInterval(refresh, 3000);

function refresh() {
$.ajax({
url: 'scripts/get_power.php', 
data: "", 
dataType: 'json',
success: function(data){
        $('#power').html(data.P + " W");
        document.title = "P=" + data.P + " W";
      }
});
}
</script>
<script>
$(function() { 
    while( $('#power').width() > $('body').width() * 0.7) { 
        $('#power').css('font-size', (parseInt($('#power').css('font-size')) - 3) + "px" ); 
    } 
});
</script>

</body>