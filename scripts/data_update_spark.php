<?php

include('datalogin.php');
$my_access_token="c256205b1d400a99f5f761f18642e144329a79d9";
$my_device="53ff6f065067544809431287";

$max_samples = 15;
$maxU = 3.3;
$bits = 4096;
$ratio = 5.667;


try {        
//get the measured sum 
//Warning: BLACK MAGIC, DO NOT TOUCH!
$url="https://api.spark.io/v1/devices/$my_device/sum?access_token=$my_access_token";

//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);

$json = json_decode($result);
$sum = $json->result;

$U1 = (($sum/$max_samples * $maxU)/$bits) * $ratio;

//calculate power (P)
$R = 68;
$P = round($U1*$U1 / $R, 3);

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

//encode to json and show on the page
$d = array('P' => $P);

echo json_encode($d);
}

catch (Exception $e) {
	//include('cron.php');
}
//write everything in the database
$sql = "INSERT INTO sensor_values (U1, P, T, weather) VALUES ($U1, '$P', '$T', '$weather')";

mysqli_query($con, $sql);
mysqli_close($con);

?>