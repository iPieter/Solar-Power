<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Lato:100' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="../elements/bootstrap.css">

<title>Analyse</title>
</head>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);


    function drawChart() {
      var jsonData = $.ajax({
          url: "get_graph_day.php",
          data: 'date=' + '<?=$_GET['date']?>',
          type: 'GET',
          dataType:"json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
       
       var formatter = new google.visualization.NumberFormat(
      {suffix: ' W'});
  formatter.format(data, 1); // Apply formatter to second column
  
      var options = {
      	vAxis: {minValue: 0, title: 'P (W)', gridlines: {count: 6}, minorGridlines: {count: 1}, viewWindowMode:'explicit',
      		viewWindow: {
	      		max:5,
	      		min:0
	      	}},
      	hAxis: {title: 't'},
        legend: 'none',
        pointSize: 0,
        colors: ['#688C00', '#719800']
      };
      
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.AreaChart(document.getElementById('graph'));
      chart.draw(data, options);
    }
    drawChart();
    
    </script>
<body>

<?php
include('datalogin.php');

//get the date to analyse
if (!($_GET['date'] == null)) {
	$date = $_GET['date'];
	$select = "SELECT * FROM sensor_values WHERE DATE(dtime) = '$date'";
}
else {
	$select = "SELECT * FROM sensor_values";
}



?>

<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-signal"></span> Grafiek</h3></div>


<div id="graph" style="height: 50%; width 100%; margin: 3;"></div>
</div>

<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span> Eigenschappen</h3></div>
 <table class="table table-striped">
 <tbody>
<?php
	$i =0;
	$av_power = 0;
    $result_g = mysqli_query($con,"SELECT * FROM sensor_values WHERE DATE(`dtime`) = '".$date."' ");
    foreach($result_g as $row_g) {
    	$i++;
    	if ($i == 1) { 
    		$dtime_f = new DateTime($row_g['dtime']);
	    	$weather = $row_g['weather'];
    	}
    	$dtime_l = new DateTime($row_g['dtime']);
    	$av_power += $row_g['P'];
    
    }
    $interval = date_diff($dtime_f, $dtime_l);
    
    //calculate the average power and total energy
    $av_power /= $i;
    $energy = round($av_power * $interval->format('%H')+ $av_power * $interval->format('%I') / 60,3);
    
    echo "<tr> <td><b>Interval: </b>".$interval->format('%H:%I:%s')."</td> <td><b>Energie: </b>".$energy." Wh</td> </tr>";
    echo "<tr> <td><b>Aantal meetwaarden: </b>".$i."</td> <td><b>Gemiddeld vermogen: </b>". round($av_power,3)." W</td> </tr>";
?>
 </tbody>
  </table>

</div>
</body>