<?php
session_start();
error_reporting('0');
//设置include_path 到 OpenSDK目录
set_include_path(dirname(__FILE__) . '/class/');
require_once 'OpenSDK/Tencent/Weibo.php';

include 'class/appkey.php';

OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

//打开session
header('Content-Type: text/html; charset=utf-8');

if(isset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]) && isset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET])){
	unset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN]);
	unset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]);
	unset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]);
	header("Location: http://t.qq.com");

}







?>