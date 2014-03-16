<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-filter"></span> Downloads per groep</h3></div>
  <div class="panel-body">
    <p>Hier kun je de data per groep downloaden, deze is opgeslagen als een csv-bestand. De waarden van iedere kolom zijn respectievelijk de originele id van de database (id), de datum en de tijd (dtime), de gemeten spanning (U in V), het gemeten vermogen (P in W), de temperatuur (T in K) en de weersomstandigheden.</p>
  </div>
  <table class="table table-striped">
 <thead><tr><th>Datum</th><th>Interval</th><th>Sensor</th><th>Aantal meetwaarden</th><th>Energie</th><th>Download</th></tr></thead>
 <tbody>
<?php
include("scripts/datalogin.php");

//get the groups of data
$result = mysqli_query($con,'SELECT * FROM groups');

//and loop throught them 
$j = 0;

foreach($result as $row) {
    $j++;
    $i = 0;
    $av_power = 0;
    
    //run another query on the groups table for the enddtime 
    $nextresult = mysqli_query($con,"SELECT dtime FROM groups WHERE id>".$row['id']);
    $next = mysqli_fetch_array($nextresult)[0];
    if ($next == null) {$next = date("Y-m-d H:i:s", time());}
    
    //run a loop for the stats of all the sensor data
    $result_g = mysqli_query($con,"SELECT * FROM sensor_values WHERE dtime >= '".$row['dtime']."' and dtime<'$next'");
    foreach($result_g as $row_g) {
    	$i++;
    	if ($i == 1) { $dtime_f = new DateTime($row_g['dtime']);}
    	$dtime_l = new DateTime($row_g['dtime']);
    	$av_power += $row_g['P'];
    }

    $interval = date_diff($dtime_f, $dtime_l);
    $date = new DateTime($row['dtime']);
    
    //calculate the average power and total energy
    $av_power /= $i;
    $energy = round(($av_power * $interval->format('%H')+ $av_power * $interval->format('%I') / 60)*100)/100;
    
    
    //print the data in a table
    $url = 'scripts/cvs_day.php?date=' . $date->format('Y-m-d');
    $btn = "<button id='date_btn_$j' type='button' class='btn btn-primary btn-xs'>Download</button>
    <script type='text/javascript'>
    $( '#date_btn_$j' ).click(function() {
    window.location = '$url';
    });
    </script>";
    
    echo "<tr>";
    echo "<td>".$date->format('d-m-Y H:i:s')."</td>";
    echo "<td>".$interval->format('%H:%I:%s')."</td>";
    echo "<td>".$row['device']."</td>";
    echo "<td>".$i."</td>";
    echo "<td>".$energy." Wh </td>";
    echo "<td>".$btn."</td>";
    echo "</tr>\n";
}

?>
 </tbody>
  </table>
</div>