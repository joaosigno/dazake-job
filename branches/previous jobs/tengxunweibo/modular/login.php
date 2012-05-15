<?php
/**
 *生成授权URL，到腾讯授权页面。
 *
 *从callback URL 返回，处理token
 */	
 	session_start();
	error_reporting('0');
	
    //设置include_path 到 OpenSDK目录
	set_include_path(dirname(dirname(__FILE__)) . '/class/');
	require_once 'OpenSDK/Tencent/Weibo.php';
	include '../class/appkey.php';
	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);
    //打开session
	header('Content-Type: text/html; charset=utf-8');
	//生成授权URL，到腾讯授权页面。
	//跳转url
	$url= '';

	$callback = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	$request_token = OpenSDK_Tencent_Weibo::getRequestToken($callback);
	$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);
	// header('Location: ' . $url);

	// 从callback URL 返回，处理token
	if( isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))
	{
         //从Callback返回时
		if(OpenSDK_Tencent_Weibo::getAccessToken($_GET['oauth_verifier']))
		{
			// $uinfo = OpenSDK_Tencent_Weibo::call('user/info');
			// echo '从Opent返回并获得授权。你的微博帐号信息为：<br />';
			echo 'Access token: ' , $_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN] , '<br />';
			echo 'oauth_token_secret: ' , $_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET] , '<br />';
			$_SESSION['access_token'] = $_GET['oauth_token'];
			// header("Location: ../home.php");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="../css/common.css" media="all" />
	<title>你被暗恋的指数</title>
	
</head>
<body>
	<div id="index" class="container">
	<a href="<?php echo $url ;?>">授权</a>
	</div>
</body>
</html>