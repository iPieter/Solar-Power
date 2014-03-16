<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300|Lato:100' rel='stylesheet' type='text/css'>

<title>Graph</title>

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
          url: "scripts/get_graph.php",
          data: 'interval=' + '<?=$_GET['interval']?>',
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
    </script>
</head>
<body>
<div id="graph" style="height: 100%; width 100%; margin: 0;"></div>

<script>
var tid = setInterval(refresh, 3000);

function refresh() {
	drawChart();
};
</script>
</body>