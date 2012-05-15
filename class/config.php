<?php

define("QQDEBUG",false);

if (defined("QQDEBUG") && QQDEBUG)

{

    @ini_set("error_reporting", E_ALL);

    @ini_set("display_errors", TRUE);

}



$_SESSION["appid"]    = 100243741;



//申请到的appkey

$_SESSION["appkey"]   = "38ec3587b7cae7aa4672f3c1c3b4cdcf"; 



//QQ登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败。

$_SESSION["callback"] = "http://www.tellyouwhere.com/SNS/QQauth/qq_callback.php";



//QQ授权api接口.按需调用

$_SESSION["scope"] = "get_info,get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo";



?>

