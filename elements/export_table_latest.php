<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"><h3 class="panel-title"><span class="glyphicon glyphicon-time"></span> Downloads van van de afgelopen tijd</h3></div>
  <div class="panel-body">
    <p>Deze data kan hier gedownload worden van een bepaalde periode tot nu, deze is opgeslagen als een csv-bestand. De waarden van iedere kolom zijn respectievelijk de originele id van de database (id), de datum en de tijd (dtime), de gemeten spanning (U in V), het gemeten vermogen (P in W), de temperatuur (T in K) en de weersomstandigheden.</p>
  </div>
  <table class="table table-striped">
 <thead><tr><th>Start</th><th>Interval</th><th>Aantal meetwaarden</th><th>Energie</th><th>Download</th></tr></thead>
 <tbody>
<?php
include("scripts/datalogin.php");

//get the groups of data
$result = mysqli_query($con,'SELECT * FROM groups');
//and loop throught them 

for ($j = 1; $j <= 12; $j++) {

    $i = 0;
    //get the data itself

    $av_power = 0;
    $result_g = mysqli_query($con,"SELECT * FROM sensor_values WHERE dtime >= DATE_SUB(NOW(),INTERVAL ".$j * 30 ." MINUTE )");
    foreach($result_g as $row_g) {
    	$i++;
    	if ($i == 1) { $dtime_f = new DateTime($row_g['dtime']);}
    	$dtime_l = new DateTime($row_g['dtime']);
    	$av_power += $row_g['P'];
    }


    if ($i == !0) {
        $interval = date_diff($dtime_f, $dtime_l);
	    $av_power /= $i;
	    $energy = round(($av_power * $interval->format('%H')+ $av_power * $interval->format('%I') / 60)*100)/100;
    }
    else
    {
	    $av_power = 0;
	    $energy = 0;
    }

    $url = 'scripts/csv.php?interval=' . $j * 30;
    $btn = "<button id='lt_btn_$j' type='button' class='btn btn-primary btn-xs'>Download</button>
    <script type='text/javascript'>
    $( '#lt_btn_$j' ).click(function() {
    window.location = '$url';
    });
    </script>";
    
    echo "<tr>";
    echo "<td>". ($j / 2) . " uur geleden </td>";
    if ($i == !0) {echo "<td>".$interval->format('%H:%I:%s')."</td>";}
    else {echo "<td></td>";} 
    echo "<td>".$i."</td>";
    echo "<td>".$energy." Wh </td>";
    echo "<td>".$btn."</td>";
    echo "</tr>\n";
}

?>
 </tbody>
  </table>
</div>