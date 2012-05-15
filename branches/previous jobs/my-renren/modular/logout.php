<?php
session_start();
require_once ('../class/requires.php');
include_once( '../class/db.class.php' );
$db = new DB();
// 退出，将时间设成无穷久；
	$sql_arr = array();
	$sql_arrp['token_insert_time'] = 0;
	$sql_arrp['access_token'] = '';
	$sql_arrp['refresh_token'] = '';
	$con = "w_id={$_SESSION['id']}";
	$updaters = $db->update(DB_TABLE_PREFIX.'renren_user',$sql_arrp,$con);
	$_SESSION['key']['renren_token']['session_key'] = '';
	header("Location: ../index.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<!--********11-19修改**********-->
	<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
	<!--********11-19修改**********-->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<title>新浪微博-by Micheal</title>	
</head>
<body>
</form>
</body>