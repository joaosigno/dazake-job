<?php
session_start();
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');


//û$_SESSION['login'] ֱ�ӻص���½����
if(!isset($_SESSION['login'])){
	header("Location: login.php");
}else{
	header("Location: home.php");
}



?>
