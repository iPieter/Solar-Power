<?php
include('datalogin.php');

if (!($_GET['interval'] == null)) {
	$interval = $_GET['interval'];
	$select = "SELECT * FROM sensor_values WHERE dtime >= DATE_SUB(NOW(),INTERVAL ".$interval." MINUTE )";
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
header("Content-Disposition: attachment; filename=".date("Y-m-d H:i:s").".csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$data";
?>