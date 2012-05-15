<?php
	session_start();
	require_once('./class/requires.php');
	if(!isset($_SESSION['id'])&&!isset($_SESSION['happy_access_token'])){
		header("Location: ./index.php");
	}else{
		$connection = new KXClient($_SESSION['happy_access_token']);
	}
	
	// ·ÖÒ³µ¼º½
	if(!isset($_GET['page'])){
		$_GET['page']=1;
	}
?>