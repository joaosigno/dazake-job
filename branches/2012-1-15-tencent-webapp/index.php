<?php
session_start();
// error_reporting('0');
//����include_path �� OpenSDKĿ¼
set_include_path(dirname(__FILE__) . '/class/');
require_once 'OpenSDK/Tencent/Weibo.php';

include 'class/appkey.php';

OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

//��session

header('Content-Type: text/html; charset=utf-8');

if(isset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]) && isset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET])){
	header("Location: home.php");
}else{
	header("Location: login.php?go_oauth=1");
	}
?>


