<?php
/**
 *生成授权URL，到腾讯授权页面。
 *
 *从callback URL 返回，处理token
 */	
 	session_start();
	error_reporting('0');
	
	// echo '11111111';
	
	
	
    //设置include_path 到 OpenSDK目录
	set_include_path(dirname(__FILE__) . '/class/');
	require_once 'OpenSDK/Tencent/Weibo.php';
	include './class/appkey.php';
	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);
    //打开session
	header('Content-Type: text/html; charset=utf-8');
	//生成授权URL，到腾讯授权页面。
	

	if(isset($_GET['go_oauth'])){
		$callback = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		$request_token = OpenSDK_Tencent_Weibo::getRequestToken($callback);
		$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);
		header('Location: ' . $url);
	}
	
	
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
			// echo '你的微博帐号信息为:<br /><pre>';
			// print_r($uinfo);
			header("Location: ./index2.php");
		}
	}