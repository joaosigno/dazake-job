<?php
/**
*没有$_SESSION['id']直接跳转到登陆
*用户账号密码与数据库匹配
*写入session
*重定向
*
*
*
*/
?>
<?php
session_start();
include_once( './class/config.php' );
include_once( './class/saetv2.ex.class.php' );
include_once( './class/db.class.php' );

//开启测试$_SESSION['id']设置为1；能在服务器读出$_SESSION['id']删除这段代码。或者在config.php文件设置WEB_TEST为假
if(WEB_TEST){
	$_SESSION['id'] = 1;
}

//没$_SESSION['id'] 直接回到登陆处。
if(!isset($_SESSION['id'])){
	header("Location: ./modular/login.php");
}

$db = new DB();
$sql = "SELECT * FROM ".DB_TABLE_PREFIX."sina_user WHERE `w_id` = {$_SESSION['id']} LIMIT 0,1";
$result = $db->get_one($sql);

	if($result && (time()-$result['token_insert_time']<EXPIRES_IN)&&!empty($result['access_token'])){
		/***重定向到微博主页***/	
		$_SESSION['weibo_token']['access_token'] = $result['access_token'];
		header("Location: weibolist.php");
	}
	elseif($result && (time()-$result['token_insert_time']<EXPIRES_IN*2)&&!empty($result['refresh_token'])){
		/***重定向到refresh_token刷新token***/
		header("Location: ./modular/refresh_token.php");
	}
	else{
		/***大于2个月没登陆，要到新浪微博重新授权***/
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
		header("Location: {$code_url}");
	}

?>

