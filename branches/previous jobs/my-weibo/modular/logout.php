<?php
session_start();
include_once( '../class/saetv2.ex.class.php' );
include_once( '../class/db.class.php' );
include_once( '../class/config.php' );
//退出
$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['weibo_token']['access_token'] );
$result = $c->end_session();

$db = new DB();
// 退出，将时间设成无穷久；
	$sql_arr = array();
	$sql_arrp['token_insert_time'] = 0;
	$sql_arrp['access_token'] = '';
	$sql_arrp['refresh_token'] = '';
	$con = "w_id={$_SESSION['id']}";
	$updaters = $db->update(DB_TABLE_PREFIX.'sina_user',$sql_arrp,$con);
	if($updaters){
		header("Location: http://weibo.com/logout.php?backurl=".WEB_SIZE);
	}
?>
