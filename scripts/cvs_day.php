<?php
include('datalogin.php');

if (!($_GET['date'] == null)) {
	$date = $_GET['date'];
	$select = "SELECT * FROM sensor_values WHERE DATE(dtime) = '$date'";
}
else {
	$select = "SELECT * FROM sensor_values";
}

$export = mysqli_query ($con, $select ) or die ( "Sql error : " . mysqli_error( ) );

$fields = mysqli_num_fields ( $export );

$data = "";

while( $row = mysqli_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$date.".csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$data";
?>