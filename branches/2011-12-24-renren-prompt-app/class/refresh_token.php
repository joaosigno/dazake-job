<?php
session_start();
require_once 'requires.php';
include_once( './db.class.php' );
$db = new DB();
$sql = "SELECT * FROM ".DB_TABLE_PREFIX."renren_user WHERE w_id LIKE '{$_SESSION['id']}'";
$result = $db->get_one($sql);
$oauth = new RenRenOauth();
$token = $oauth->refreshAccessToken($result['refresh_token']);

	if ($token) {
        //用户入库
		$sql = "SELECT * FROM ".DB_TABLE_PREFIX."renren_user WHERE w_id LIKE '{$_SESSION['id']}'";
		$result = $db->get_one($sql);
	
		if(empty($result)){
			$sql_arr = array();
			$sql_arr['w_id'] = $_SESSION['id'];
			$sql_arr['w_name'] =$_SESSION['name'];
			$db->insert(DB_TABLE_PREFIX.'renren_user',$sql_arr);
		}

		// token入库
		$sql_arr = array();
		$sql_arrp['renren_id'] = $token['user']['id'];
		$sql_arrp['renren_name'] = $token['user']['name'];
		$sql_arrp['access_token'] = $token['access_token'];
		$sql_arrp['refresh_token'] = $token['refresh_token'];
		$sql_arrp['token_insert_time'] = time();
		$con = "w_id={$_SESSION['id']}";
		$updaters = $db->update(DB_TABLE_PREFIX.'renren_user',$sql_arrp,$con);
		header('Location: ../index.php');
	}
?>