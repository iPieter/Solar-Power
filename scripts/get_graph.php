<?php
include("datalogin.php");

if (!($_GET['interval'] == null)) {$interval = $_GET['interval'];}
else {$interval = 10;}

$result = mysqli_query($con,'SELECT * FROM sensor_values WHERE dtime >= DATE_SUB(NOW(),INTERVAL '.$interval.' MINUTE )' );


$rows = array();
$table = array();
$table['cols'] = array(

array('label' => 'Tijd', 'type' => 'string'),
array('label' => 'Vermogen', 'type' => 'number')

);
    /* Extract the information from $result */
    foreach($result as $r) {

      $temp = array();
      $time_raw = strtotime($r['dtime']);
      $time = date('H:i', $time_raw);
      $temp[] = array('v' => (string) $time); 


      $temp[] = array('v' => (float) $r['P']); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;


?>