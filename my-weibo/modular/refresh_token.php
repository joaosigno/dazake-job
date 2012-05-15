<?php
	session_start();

	include_once( '../class/config.php' );
	include_once( '../class/saetv2.ex.class.php' );
	include_once( '../class/db.class.php' );
	
	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
	$db = new DB();
	$token = '';
	$sql = "SELECT * FROM ".DB_TABLE_PREFIX."sina_user WHERE `w_id` = {$_SESSION['id']} LIMIT 0,1";
	$result = $db->get_one($sql);
	if($result && (time()-$result['token_insert_time']<EXPIRES_IN*2)&&!empty($result['refresh_token'])){
		try {
			$token = $o->getAccessToken( 'token', $result ) ;
		}catch (OAuthException $e) {
		}
	}
	
	if (!empty($token)) {
        //用户不存在，用户入库
		$sql = "SELECT * FROM ".DB_TABLE_PREFIX."sina_user WHERE w_id LIKE '{$_SESSION['id']}'";
		$result = $db->get_one($sql);
	
		if(empty($result)){
			$sql_arr = array();
			$sql_arr['w_id'] = $_SESSION['id'];
			$sql_arr['w_name'] =$_SESSION['name'];
			$db->insert(DB_TABLE_PREFIX.'sina_user',$sql_arr);
		}

   	 // token入库
		$sql_arr = array();
		$sql_arrp['access_token'] = $token['access_token'];
		$sql_arrp['token_insert_time'] = time();
		//有refresh_token的话，也把refresh_token入库
		if(isset($token['refresh_token']))
			$sql_arrp['refresh_token'] = $token['refresh_token'];
		$con = "w_id={$_SESSION['id']}";
		$updaters = $db->update(DB_TABLE_PREFIX.'sina_user',$sql_arrp,$con);
		// setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
		header("Location: index.php");
		}