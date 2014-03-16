<?php

include('datalogin.php');

//get the measured voltage (U1) from the arduino
$U1 = $_GET['U1'];

//calculate power (P)
$R = 63.4;
$P = $U1*$U1 / $R;

//get the temperature (T)
$json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=flobecq,be');
$json = json_decode($json);
$T = $json->main->temp;

$weather = $json->weather[0]->description;

//check if the data fetched from the api isn't null
if ($T == null) {
	//get the temperature (T) again
	$json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=flobecq,be');
	$json = json_decode($json);
	$T = $json->main->temp;

	$weather = $json->weather[0]->description;
}

//write everything in the database
$sql = "INSERT INTO sensor_values (U1, P, T, weather) VALUES ($U1, '$P', '$T', '$weather')";

mysqli_query($con, $sql);
mysqli_close($con);

?>