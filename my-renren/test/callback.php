<?php
// 170068|7.de09805814123f011c1f4e5261eeaef5.5184000.1327914000-363524545
// 170068|7.33832a158aff303ebd93bddf90f23df1.5184000.1327906800-363524545





session_start();
require_once '../class/requires.php';
include_once( '../class/db.class.php' );
$oauth = new RenRenOauth();
$db = new DB();
$sql = "SELECT * FROM renren_user WHERE w_id LIKE '{$_SESSION['id']}'";
$result = $db->get_one($sql);

$token = $oauth->refreshAccessToken($result['refresh_token']);
print_r($token);
// if ($token) {
// 用户入库
	// $sql = "SELECT * FROM renren_user WHERE w_id LIKE '{$_SESSION['id']}'";
	// $result = $db->get_one($sql);
	
	// if(empty($result)){
		// $sql_arr = array();
		// $sql_arr['w_id'] = $_SESSION['id'];
		// $sql_arr['w_name'] =$_SESSION['name'];
		// $db->insert('renren_user',$sql_arr);
	// }

// token入库
	// $sql_arr = array();
	// $sql_arrp['access_token'] = $token['access_token'];
	// $sql_arrp['refresh_token'] = $token['refresh_token'];
	// $sql_arrp['token_insert_time'] = time();
	// $con = "w_id={$_SESSION['id']}";
	// $updaters = $db->update('renren_user',$sql_arrp,$con);
	// setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	
// $_SESSION['token'] = $token ;
// $access_token = $_SESSION['token']['access_token'];
// $key = $oauth->getSessionKey($access_token);
// $_SESSION['key'] = $key;
// header('Location: ../home.php');
// }
?>