<?php
require_once('twitteroauth/twitteroauth.php');
include('datalogin.php');

//check if the message hasnt been send already
//$sendresult = mysqli_query($con,"SELECT send_notification FROM settings");
//$send = mysqli_fetch_array($sendresult)[0];
/*
echo $send;
if (!$send) {
$i = 0;
$result = mysqli_query($con,"SELECT * FROM sensor_values WHERE dtime >= DATE_SUB(NOW(),INTERVAL '2' MINUTE )");
foreach($result as $row) {$i++;}
*/

//if no records are aveliable, the sensor must be offline
//if ($i == 0) {

// Get everything you need from the dev.twitter.com/apps page
$consumer_key = 'tuiq4P8JTi0IRz1GDxsdQ';
$consumer_secret = 'oDge1BquNtakcyWrtJEL1eVBCvEbWnmP4Gf7fr2TXM';
$oauth_token = '551272345-bNvq6clEM9bWf0eID905Y13cC8brDfWDomo5QAjV';
$oauth_token_secret = 'OMPNkgYMM5a9AuITikMwsjANPk0alyrf7bMFWh5NVfktb';

// Initialize the connection
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

// Send a direct messages
$options = array("screen_name" => "SolarPanel9", "text" => "It seems like the sensor is offline");
$connection->post('direct_messages/new', $options);
//mysqli_query($con,"UPDATE settings SET send_notification=1 WHERE id=1");
//}}
//else {mysqli_query($con,"UPDATE settings SET send_notification=0 WHERE id=1");}
?>

<script type="text/javascript">
    window.close();
</script>