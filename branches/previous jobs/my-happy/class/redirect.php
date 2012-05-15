<?php
session_start();
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'requires.php');
$db = new DB();

if(array_key_exists('code', $_GET))
{
	$connect = new KXClient();
	$response = $connect->getAccessTokenFromCode($_GET['code']);
	if(isset($response->access_token))
	{
		//用户入库
		$sql = "SELECT * FROM ".DB_TABLE_PREFIX."happy_user WHERE w_id LIKE '{$_SESSION['id']}'";
		$result = $db->get_one($sql);
	
		if(empty($result)){
			$sql_arr = array();
			$sql_arr['w_id'] = $_SESSION['id'];
			$db->insert(DB_TABLE_PREFIX.'happy_user',$sql_arr);
		}

		// token入库
		$sql_arr = array();
		$sql_arrp['access_token'] = $response->access_token;
		$sql_arrp['refresh_token'] = $response->refresh_token;
		$sql_arrp['token_insert_time'] = time();
		$con = "w_id={$_SESSION['id']}";
		$updaters = $db->update(DB_TABLE_PREFIX."happy_user",$sql_arrp,$con);
		header('Location: ../index.php');
	} 
}
elseif (array_key_exists('access_token', $_GET)) {	
	$_SESSION['access_token'] = $_GET['access_token'];	
	$_SESSION['refresh_token'] = $_GET['refresh_token'];
	header("Location: ../index.php");
	
    //用户入库
		$sql = "SELECT * FROM ".DB_TABLE_PREFIX."happy_user WHERE w_id LIKE '{$_SESSION['id']}'";
		$result = $db->get_one($sql);
	
		if(empty($result)){
			$sql_arr = array();
			$sql_arr['w_id'] = $_SESSION['id'];
			$db->insert(DB_TABLE_PREFIX.'happy_user',$sql_arr);
		}

		// token入库
		$sql_arr = array();
		$sql_arrp['access_token'] = $_GET['access_token'];
		$sql_arrp['refresh_token'] = $_GET['refresh_token'];
		$sql_arrp['token_insert_time'] = time();
		$con = "w_id={$_SESSION['id']}";
		$updaters = $db->update(DB_TABLE_PREFIX."happy_user",$sql_arrp,$con);
		header('Location: ../index.php');
}
?>
