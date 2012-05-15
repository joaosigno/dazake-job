<?php
	session_start();
	require_once '../class/requires.php';
	$client = new RenRenClient();
	$session_key = $_SESSION['key']['renren_token']['session_key'];
	$client->setSessionKey($session_key);
	echo $session_key;
	
	// echo $_POST['photoId'].$_POST['photoComment'].$_POST['photoUserId'];
	print_r($us =  $client->POST('photos.addComment',array($_POST['photoUserId'],$_POST['photoComment'],$_POST['photoId'])));


	
?>