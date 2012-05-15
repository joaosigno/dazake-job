<?php
	session_start();
	require_once 'requires.php';
	if(isset($_GET['code'])){
		$code = $_GET['code'];
		$oauth = new RenRenOauth();
		$token = $oauth->getAccessToken($code);
	}else{
		header('Location: ../index.php');
	}
	
	if ($token) {
       
		// token写入session
		$_SESSION['access_token'] = $token['access_token'];
		header('Location: ../index.php');
	}
?>