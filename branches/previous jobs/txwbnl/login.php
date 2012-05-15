<?php
///**
// * just a demo
// *
// * 仅仅是个demo，未有严格考虑，请不要使用这个简单逻辑到生产环境。
// *
// */
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
	$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);
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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/common.css" media="all" />
	<?php include_once('modular/header.php');?>
	
	</div>
	<div id="container">
		<div id="top">
			<img src="img/logo.png" alt="" id="logo" /><span id="hit">人气：672993</span>
		</div>
		<div id="mid"><p>珍爱生命，健康生活，想知道你的寿命有多长吗？ 这是一个科学的测试，所有24个选项都必须完成！</p></div>
		<div id="bottom">
			<a href = "<?php echo $url ;?>" ><input type="submit" src="img/login.png" value=""/></a>
			<img src="img/example.jpg" alt="" id="example" />
		</div>
	</div>
	<?php include_once('modular/footer.php');?>
</body>
</html>