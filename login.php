<?php
	session_start();
	error_reporting('0');

	// 设置include_path 到 OpenSDK目录
	set_include_path(dirname(__FILE__) . '/class/');
	require_once 'OpenSDK/Tencent/Weibo.php';

	include 'class/appkey.php';

	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

	header('Content-Type: text/html; charset=utf-8');

	// 去授权页面
	if(isset($_GET['go_oauth']))
	{
		$callback = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		$request_token = OpenSDK_Tencent_Weibo::getRequestToken($callback);
		$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token,false);
		// header('Location: ' . $url);
	}

	// 回调处理
	if( isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))
	{
		// 从Callback返回时
		if(OpenSDK_Tencent_Weibo::getAccessToken($_GET['oauth_verifier']))
		{
			// $uinfo = OpenSDK_Tencent_Weibo::call('user/info');
			// echo '从Opent返回并获得授权。你的微博帐号信息为：<br />';
			header("Location: home.php");
			// echo '1111111Access token: ' , $_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN] , '<br />';
			// echo 'oauth_token_secret: ' , $_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET] , '<br />';
		
			// echo '你的微博帐号信息为:<br /><pre>';
			// var_dump(OpenSDK_Tencent_Weibo::ACCESS_TOKEN);
		}
		else
		{
			var_dump($_SESSION);
			echo '获得Access Tokn 失败';
		}
		$exit = true;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>2012年，你的幸运日是哪一天？</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="header">
	<div class="c">
		<div class="logo"></div>
	</div>
</div><div class="main clearfix">
	<div class="left">
		<div class="title">			<div class="l"><div style="padding-left:40px;"><img src="images/logo.jpg" /></div></div>			<div class="r"><span>人气<span><div class="n" id="usenum">124,018</div></div>
		</div>
		<div class="intro">2012终于来了<br />想知道你在这一年的幸运日是哪一天吗？</div>
		<div class="login"><a href="<?php echo $url ;?>"><img src="images/qq_login.png" width="230" height="48" /></a></div>
		<div class="pic">
			<img src="images/example.jpg" />
		</div>
	</div><!--/left-->
	<div class="right">
		<dl class="hot">
	<dt>广告barners：</dt>
		
	</dl>
	</div>
</div><!--/main-->
<div class="footer">
	Copyright &copy;2012 Ci123.com. All Rights Reserved
</div>
</div>
</body>
</html>
