<?php
	require_once './signature-to-image.php';

	$json = $_POST['output'];
	$img = sigJsonToImage($json);
	$filename = 'signature'.time().'.png';
	imagepng($img, './images/'.$filename);
	echo $filename;
?>