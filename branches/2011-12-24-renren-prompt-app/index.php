<?php
session_start();
include_once( './class/db.class.php' );
require_once 'class/requires.php';
header('Content-Type: text/html; charset=utf-8');

//判断session是否设置，到授权页面

	if(isset($_SESSION['access_token'])){
		$oauth = new RenRenOauth();
		try{
			$key = $oauth->getSessionKey($_SESSION['access_token']);
		}catch (Exception $e) {

		}
		
		if(isset($key)){
			$_SESSION['key'] = $key;
			header("Location: home.php");
		}else{
			header("Location: modular/logout.php");
		}
		
	}else{
		header("Location: login.php");
	}
?>