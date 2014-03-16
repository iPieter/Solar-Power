<div class="panel panel-default" style="margin: 3%;">
  <!-- Default panel contents -->
  <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-calendar"></span> Downloads per dag</h3></div>
  <div class="panel-body">
    <p>Hier kun je de data per dag downloaden, deze is opgeslagen als een csv-bestand. De waarden van iedere kolom zijn respectievelijk de originele id van de database (id), de datum en de tijd (dtime), de gemeten spanning (U in V), het gemeten vermogen (P in W), de temperatuur (T in K) en de weersomstandigheden.</p>
  </div>
  <table class="table table-striped">
 <thead><tr><th>Datum</th><th>Analyse</th><th>Download</th></tr></thead>
 <tbody>
<?php
include("scripts/datalogin.php");

//get the groups of data
//$result = mysqli_query($con,'SELECT * FROM groups');
$result = mysqli_query($con,'SELECT dtime FROM sensor_values GROUP BY DATE(dtime)');

//and loop throught them 
$j = 0;
foreach($result as $row) {

    //$interval = date_diff($dtime_f, $dtime_l);
    $date = new DateTime($row['dtime']);
    
    //$av_power /= $i;
    //$energy = round(($av_power * $interval->format('%H')+ $av_power * $interval->format('%I') / 60)*100)/100;
    
    $urlan = 'scripts/analyse.php?date=' . $date->format('Y-m-d');
    $urldl = 'scripts/cvs_day.php?date=' . $date->format('Y-m-d');
    
    //set the code for the analyse btn
    $analyse = "<button id='date_btn_analyse_$j' type='button' class='btn btn-default btn-xs'>Bekijk analyse</button>
    <script type='text/javascript'>
    $( '#date_btn_analyse_$j' ).click(function() {
    window.location = '$urlan';
    });
    </script>";;
    
    //set the code for the download btn
    $dl = "<button id='date_btn_dl_$j' type='button' class='btn btn-primary btn-xs'>Download</button>
    <script type='text/javascript'>
    $( '#date_btn_dl_$j' ).click(function() {
    window.location = '$urldl';
    });
    </script>";
    
    echo "<tr>";
    echo "<td>".$date->format('d-m-Y')."</td>";
    //echo "<td>".$interval->format('%H:%I:%s')."</td>";   
    //echo "<td>".$i."</td>";
    echo "<td>".$analyse."</td>";
    echo "<td>".$dl."</td>";
    echo "</tr>\n";
    $j++;
}

?>
 </tbody>
  </table>
</div>