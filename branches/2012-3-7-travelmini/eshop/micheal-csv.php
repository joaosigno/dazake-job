<?php
session_start();
$data = date("Ymdhis");  
$filename = $data . '.csv';
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=" . $filename );
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Expires:0');
header('Pragma:public');
$contant = $_SESSION['invoice'];

echo "Customer Name,Address,City,State,PostCode\n";
foreach ($contant as $key => $value) {
	echo $value['customname'] .','.$value['address'].','.$value['city'].','.$value['state'].','.$value['zip']."\n";
}
?>