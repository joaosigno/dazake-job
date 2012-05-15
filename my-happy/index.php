<?php
/**
*没有$_SESSION['id']直接跳转到登陆页面
*授权有效，写入session，进入用户首页
*授权无效，如果refresh_token还有效，用refresh_token刷新授权
*refresh_token也过期。只能到人人网重新授权
*/
?>
<?php
session_start();
require_once('./class/requires.php');

//开启测试$_SESSION['id']设置为1；能在服务器读出$_SESSION['id']删除这段代码。或者在config.php文件设置WEB_TEST为假
if(WEB_TEST){
	$_SESSION['id'] = 1;
}

//没$_SESSION['id'] 直接回到登陆处。
if(!isset($_SESSION['id'])){
	header("Location: ./modular/login.php");
}

//根据$_SESSION['id']读出用户信息
$db = new DB();
$sql = "SELECT * FROM ".DB_TABLE_PREFIX."happy_user WHERE `w_id` = {$_SESSION['id']} LIMIT 0,1";
$result = $db->get_one($sql);


	if($result && (time()-$result['token_insert_time']<EXPIRES_IN)&&!empty($result['access_token'])){
		/***重定向到开心主页***/
		$_SESSION['happy_access_token'] = $result['access_token'];
		header("Location: ./home.php");
		
		
	}elseif($result && (time()-$result['token_insert_time']<EXPIRES_IN*2)&&!empty($result['refresh_token'])){
		/***重定向到refresh_token刷新token***/
		header("Location: ./class/refresh_token.php");
	}else{
		/***大于2个月没登陆，要到人人网重新授权***/
		header("Location: ./class/authorize.php");
		// echo '很久没有登录';
	}
?>


