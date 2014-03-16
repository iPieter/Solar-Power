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

<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-signal"></span> Grafiek</h3></div>


<div id="graph" style="height: 50%; width 100%; margin: 3;"></div>
</div>
