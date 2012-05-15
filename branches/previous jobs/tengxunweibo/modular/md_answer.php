
<?php
/**
 *当$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]和$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]有数据。可以使用。
 *
 *从callback URL 返回，处理token
 */
	error_reporting('0');
    // 设置include_path 到 OpenSDK目录
	set_include_path(dirdirname(dirname(__FILE__)) . '/class/');
	require_once 'OpenSDK/Tencent/Weibo.php';
	require_once './class/appkey.php';
	require_once './class/config.php';
	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);
    // 打开session
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	// print_r($con_arr);
	// $uinfo = OpenSDK_Tencent_Weibo::call('user/info');
	// $uinfo = OpenSDK_Tencent_Weibo::call('user/info');
	// print_r($uinfo);
	// echo getIP();
	
	
	// 发图片微博
	$send_con_arr = array();
	$send_con_arr['content'] = $con_arr [0];
	$send_con_arr['clientip'] = getIP();
	
	
		print_r( OpenSDK_Tencent_Weibo::call('t/add_pic', $send_con_arr, 'POST', array(
			'pic' => array(
			'type' => 'image/jpg',
			'name' => '0.jpg',
			'data' => file_get_contents('test.png'),
			),
		)) ); 
		// $send_con_arr = array();
	// $send_con_arr['content'] = $con_arr [1];
	// $send_con_arr['clientip'] = getIP();
	
	
		// print_r( OpenSDK_Tencent_Weibo::call('t/add_pic', $send_con_arr, 'POST', array(
			// 'pic' => array(
			// 'type' => 'image/jpg',
			// 'name' => '0.jpg',
			// 'data' => file_get_contents('test.png'),
			// ),
		// )) );
	// $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

	// header("Location: ./modular/authorize.php?go_oauth=1");
?>

