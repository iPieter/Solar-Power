<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span> Eigenschappen</h3></div>
 <table class="table table-striped">
 <tbody>
<?php
$i =0;
$av_power = 0;
$drop = 0;
$weather = "";
$result_g = mysqli_query($con,"SELECT * FROM sensor_values WHERE DATE(`dtime`) = '".$date."' ");
    foreach($result_g as $row_g) {
    	$i++;
    	
    	//check if sensor dropped out
    	//needs to be done before setting the new sensor value
    	if ($row_g['P'] == 0 && $power > 0.1) {
	    	$drop++;
    	}
    	
    	$power = $row_g['P'];
    	
    	//get the weather
    	if ($power > 0.3 && $weather == null) { 
    		$dtime_f = new DateTime($row_g['dtime']);
	    	$weather = $row_g['weather'];
    	}
    		
    	$dtime_l = new DateTime($row_g['dtime']);
    	$av_power += $power;
    
    }
    $interval = date_diff($dtime_f, $dtime_l);
    
    //calculate the average power and total energy
    $av_power /= $i;
    $energy = round($av_power * $interval->format('%H')+ $av_power * $interval->format('%I') / 60,3);
    
    echo "<tr> <td><b>Interval: </b>".$interval->format('%H:%I:%s')."</td> <td><b>Energie: </b>".$energy." Wh</td> </tr>";
    echo "<tr> <td><b>Aantal meetwaarden: </b>".$i."</td> <td><b>Gemiddeld vermogen: </b>". round($av_power,3)." W</td> </tr>";
    echo "<tr> <td><b>Weer: </b>".$weather."</td> <td><b>Vermoedelijke storingen: </b>". $drop."</td> </tr>";
    
?>
 </tbody>
  </table>

</div>
