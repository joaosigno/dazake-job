<?php
	session_start();
	if(!isset($_SESSION['key'])){
		header("Location: ./index.php");
	}else{
		require_once ('./class/requires.php');
		$client = new RenRenClient();
		$session_key = $_SESSION['key']['renren_token']['session_key'];
		$client->setSessionKey($session_key);
		//��ȡ�û���Ϣ
		$us =  $client->POST('users.getInfo',''); 
	}

?>