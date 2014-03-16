<?php
include("datalogin.php");

if (!($_GET['interval'] == null)) {$interval = $_GET['interval'];}
else {$interval = 10;}

$result = mysqli_query($con,'SELECT * FROM sensor_values WHERE dtime >= DATE_SUB(NOW(),INTERVAL '.$interval.' MINUTE )' );

$result2 = mysqli_query($con,'SELECT * FROM sensor_values WHERE dtime >= DATE_SUB(NOW() - INTERVAL 1 DAY,INTERVAL '.$interval.' MINUTE ) AND dtime <= NOW( ) - INTERVAL 1 
DAY' );

$rows = array();
$table = array();
$table['cols'] = array(

array('label' => 'Tijd', 'type' => 'string'), 
array('label' => 'Vermogen', 'type' => 'number'),
array('label' => 'Vermogen gisteren', 'type' => 'number')

);

$i=0;
    /* Extract the information from $result */
    foreach($result as $r) {
	  
      $temp = array();
      $time_raw = strtotime($r['dtime']);
      $time = date('H:i', $time_raw);
      $temp[] = array('v' => (string) $time); 
      
      $r2 = $result2->fetch_array(MYSQLI_BOTH);
      
      $temp[] = array('v' => (float) $r['P']);
      $temp[] = array('v' => (float) $r2['P']);  
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;


?>