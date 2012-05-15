<?php
//session_start();
//error_reporting('0');
//设置include_path 到 OpenSDK目录
//set_include_path(dirname(__FILE__) . '/class/');
//require_once 'OpenSDK/Tencent/Weibo.php';
//
//include 'class/appkey.php';
//
//OpenSDK_Tencent_Weibo::init($appkey, $appsecret);
//
//打开session
// print_r($_POST['cb_guanzhu']);
//
//header('Content-Type: text/html; charset=utf-8');
//	if(isset($_POST['q0'])&&isset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]) && isset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET])){
//		$con_arr = array();	
//		$con_arr[55] = '「眼波传情型」55% 感情丰富的你会有意无意地透过眼神放电，不自觉地让别人暗恋你。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com 分享自@翻到就行';
//		$con_arr[20] = '「反应白目型」20% 你活在自己世界中，反应永远慢半拍，就算别人对你示好，你反而还感应不到。[呵呵]还真是。看看#你被人暗恋的指数有多高';
//		$con_arr[99] = '「狮子示爱型」99% 你会不自觉地经由身体的接触，让别人觉得你对他有意思，相对地也使别人对你献殷勤的机会大增。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com 分享自@翻到就行';
//		$con_arr[40] = '「无聊解闷型」40% 当生活乏味无聊时，你会偶尔放放电，让人家觉得平常不太出色的你还满吸引人的。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com 分享自@翻到就行';
//		$con_arr[80] = '「对话传情型」80% 感性的你容易在言语中向别人挑逗暗示，让人觉得你好像在告诉对方可以接近。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com分享自@翻到就行';
//		
//		$uinfo = OpenSDK_Tencent_Weibo::call('user/info');
//		
//		
//		if(isset($_POST['send_weibo_n']) || isset($_POST['send_weibo_y'])  ){
//			/**
//			 * 上传一张图片并发一条微博
//			 */
//		
//			$result = OpenSDK_Tencent_Weibo::call('t/add_pic', array(
//				'content' => $con_arr[$_POST['q0']],
//				'clientip' => '123.119.32.253',
//			), 'POST', array(
//			'pic' => array(
//			'type' => 'image/jpg',
//			'name' => '0.jpg',
//			'data' => file_get_contents('p'.$_POST['q0'].'.jpg'),
//			),
//			)) ;
//		}
//			
//		if(isset($_POST['send_weibo_y']) || isset($_POST['cb_guanzhu'])){
//				$friendadd = OpenSDK_Tencent_Weibo::call('friends/add',array('name' => 'nacheal1989'),'post');
//		}
//	}
//剩余的年：
// print_r($_POST['nowAge']);
//剩余的月：$_POST['thisMonth']
//剩余的日：$_POST['thisDay']
//剩余的分：$_POST['thisMoment']
//剩余的秒：
//echo $_POST['thisSecond'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/last.css" media="all" />
	<?php include_once('modular/header.php');?>
	<a href="" id="logout">退出</a>
	</div>
	<div id="container">
		<div id="top">
			<img src="img/logo.png" alt="" id="logo" /><span id="hit">人气：672993</span>
		</div>
		<div id="mid"><p><img src="img/ok.png" alt="" />恭喜！已成功将您的鉴定结果发送到微博！！</p>
		<a href="index.php">>>再玩一次</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="http://t.qq.com">>>查看微博</a>
		</div>
	</div>
	<?php include_once('modular/footer.php');?>
</body>
</html>