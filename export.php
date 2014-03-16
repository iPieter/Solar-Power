<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Lato:100' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="elements/bootstrap.css">

<title>Export</title>
</head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<body>

<div id="dates" class="groups">
<?php
include("elements/export_table_dates.php"); 
?>
</div> 

<div id="latest" class="groups"> 
<?php
include("elements/export_table_latest.php"); 
?>
</div>


<!--
<div id="groups" class="groups">
<?php
//include("elements/export_table_groups.php"); 
?>
</div>
-->

</body>