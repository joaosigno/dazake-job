<?php
session_start();
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');


//没$_SESSION['login'] 直接回到登陆处。
if(!isset($_SESSION['login'])){
	header("Location: login.php");
}else{
	header("Location: home.php");
}



?>
