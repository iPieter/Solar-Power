<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span> Eigenschappen</h3></div>
 <table class="table table-striped">
 <tbody>
<?php
//check if this day was already analysed and stored in cache. 
$result = mysqli_query($con, "SELECT * FROM `solar_power`.`days` WHERE DATE(`date`) = '".$date."' ORDER BY id DESC LIMIT 1");
if (mysqli_num_rows($result) > 0) {
$result = mysqli_query($con, "SELECT * FROM `solar_power`.`days` WHERE DATE(`date`) = '".$date."' ORDER BY id DESC LIMIT 1");

	foreach($result as $r) {

	$row = mysqli_fetch_row($result)[0];	
	echo "<tr> <td><b>Interval: </b>".$r['interval_l']."</td> <td><b>Energie: </b>".$r['energy']." Wh</td> </tr>";
	echo "<tr> <td><b>Aantal meetwaarden: </b>".$r['number']."</td> <td><b>Gemiddeld vermogen: </b>". $r['av_power']." W</td> </tr>";
	echo "<tr> <td><b>Weer: </b>".$r['weather']."</td> <td><b>Vermoedelijke storingen: </b>". $r['interupts']."</td> </tr>";
}
}
else {
$i =0;
$av_power = 0;
$drop = 0;
$weather = "";
$power = 0;
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
    	if ($power > 0.05 && $weather == null) { 
    		$dtime_f = new DateTime($row_g['dtime']);
	    	$weather = $row_g['weather'];
    	}
    	
    	//get the weather and dtime a first time to make sure
    	if ($i == 1) {
	    	$dtime_f = new DateTime($row_g['dtime']);
	    	$weather = $row_g['weather'];
    	}
    		
    	$dtime_l = new DateTime($row_g['dtime']);
    	$av_power += $power;
    
    }
    
    if ($i > 2) {
	    $interval = date_diff($dtime_f, $dtime_l);
	    
	    //calculate the average power and total energy
	    $av_power /= $i;
	    $energy = round($av_power * $interval->format('%H')+ $av_power * $interval->format('%I') / 60,3);
	    echo "<tr> <td><b>Interval: </b>".$interval->format('%H:%I:%s')."</td> <td><b>Energie: </b>".$energy." Wh</td> </tr>";
	    echo "<tr> <td><b>Aantal meetwaarden: </b>".$i."</td> <td><b>Gemiddeld vermogen: </b>". round($av_power,3)." W</td> </tr>";
	    echo "<tr> <td><b>Weer: </b>".$weather."</td> <td><b>Vermoedelijke storingen: </b>". $drop."</td> </tr>";

	    //check if they day is over and this can be stored in cache
	    if (!(strtotime($date) == strtotime('now'))) {
		    mysqli_query($con,"INSERT INTO `solar_power`.`days` (`interval_l`, `energy`, `number`, `av_power`, `weather`, `interupts`, `date`, `created`) VALUES ('".$interval->format('%H:%I:%s')."', '$energy', '$i', '". round($av_power,3)."', '$weather', '$drop', '$date', CURRENT_TIMESTAMP);");
	    }
   }
   else {
	   $av_power /= $i;
	   echo "<tr> <td><b>Interval: </b> 00:00:00 </td> <td><b>Energie: </b> 0.000 Wh</td> </tr>";
	   echo "<tr> <td><b>Aantal meetwaarden: </b>".$i."</td> <td><b>Gemiddeld vermogen: </b>". round($av_power,3)." W</td> </tr>";
	   echo "<tr> <td><b>Weer: </b> Onvoldoende gegevens </td> <td><b>Vermoedelijke storingen: </b> 0 </td> </tr>";

   } 
}
?>
 </tbody>
  </table>

</div>
