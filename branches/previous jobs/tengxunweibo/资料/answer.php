<?php
	// print_r($_POST['q0']);
	
/**
 *当$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]和$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]有数据。可以使用。
 *
 *从callback URL 返回，处理token
 */
 	session_start();
	error_reporting('0');
    //设置include_path 到 OpenSDK目录
    set_include_path(dirname(__FILE__) . '/class/');
    require_once 'OpenSDK/Tencent/Weibo.php';
	include 'class/appkey.php';
	include 'class/config.php';
	echo 'Access token: ' , $_SESSION['tencent_access_token'] , '<br />';
	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

    //打开session

	header('Content-Type: text/html; charset=utf-8');
	
	if(isset($_POST['q0'])){
		// 发图片微博
		$send_con_arr = array();
		$send_con_arr['content'] = $con_arr [$_POST['q0']];
		$send_con_arr['clientip'] = getIP();
		
		/**
		 * 上传一张图片并发一条微博
		 */
	
	var_dump( OpenSDK_Tencent_Weibo::call('t/add_pic', array(
		'content' => '可可可再tmd测试发表一条带图片的微博',
		'clientip' => '123.119.32.253',
	), 'POST', array(
		'pic' => array(
			'type' => 'image/jpg',
			'name' => '0.jpg',
			'data' => file_get_contents('p20.jpg'),
		),
	)) );

	}
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/common.css" media="all" />
	<title>你被暗恋的指数</title>
</head>
<body>
	<div id="container1" class="container" style="background: url('upload/b<?php echo $_POST['q0'] ; ?>.jpg');">
			<div id="main">
					<form action="./modular/authorize.php">
							<textarea name="main" id="inputzone" cols="30" rows="10" value=""><?php echo $send_con_arr['content'] ; ?></textarea>
							<div id="selectbox">
								<input type="checkbox" id="check"/><span id="guanzhu">关注翻到官方微博......</span>
							</div>
							<input type="submit"  name = "go_oauth" src="img/button.png" id="send"/>
							<span id="share">点击提交按钮分享到新浪微博</span>
						</form>
						<a href="home.php" id="again">再测一遍</a>
				</div>
	</div>
</body>
</html>