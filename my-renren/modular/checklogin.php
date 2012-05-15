<?php
	session_start();
	if(!isset($_SESSION['id'])&&!isset($_SESSION['key'])){
		header("Location: ./index.php");
	}else{
		require_once ('./class/requires.php');
		$client = new RenRenClient();
		$session_key = $_SESSION['key']['renren_token']['session_key'];
		$client->setSessionKey($session_key);
		//获取用户信息
		$us =  $client->POST('users.getInfo',''); 
		//获取表情
		$bq =  $client->POST('status.getEmoticons','');
		
	}
	
	// 分页导航
	if(!isset($_GET['page'])){
		$_GET['page']=1;
	}
?>