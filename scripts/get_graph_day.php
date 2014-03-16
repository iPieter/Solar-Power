<?php
include("datalogin.php");

if (!($_GET['date'] == null)) {$date = $_GET['date'];}

$result = mysqli_query($con,"SELECT * FROM sensor_values WHERE DATE(`dtime`) = '".$date."' ");


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