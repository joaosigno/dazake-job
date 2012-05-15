<?php


	//剩余的年：
	 // print_r($_POST['nowAge']);
	//剩余的月：$_POST['thisMonth']
	//剩余的日：$_POST['thisDay']
	//剩余的分：$_POST['thisMoment']
	//剩余的秒：$_POST['thisSecond']
	
session_start();
set_include_path(dirname(__FILE__) . '/class/');
error_reporting('0');
//设置include_path 到 OpenSDK目录
require_once 'OpenSDK/Tencent/Weibo.php';
include 'class/appkey.php';
OpenSDK_Tencent_Weibo::init($appkey, $appsecret);
header('Content-Type: text/html; charset=utf-8');
require_once('class/thumb.class.php');

//图片处理
	//剩余的年：
	$nowAge = $_POST['nowAge'];
	//剩余的月：
	$thisMonth = $_POST['thisMonth'];
	//剩余的日：
	$thisDay = $_POST['thisDay'];
	//剩余的分：
	$thisMoment = $_POST['thisMoment'];
	//剩余的秒：
	$thisSecond = $_POST['thisSecond'];
	
    // 活着的年
	$liveYear = $_POST['nowAge'] + 2011;
    // 活着的月
	$liveMonth = $_POST['thisMonth'] + 11;
    // 活着的日
	$liveDay = $_POST['thisDay'] +  15 ;
	
	//发送微博内容
	$con = "经过科学标准测试，我居然还可以活 {$nowAge} 年！你知道你还能活多少年吗？完成24个专业测试题就能鉴定出，快来试试吧！#测试你的寿命#";
	
	//生成图片
if(isset($_POST['nowAge'])){
	$t = new ThumbHandler();
 
	$t->setSrcImg("upload/lifetest.jpg");
	$t->setMaskFont("upload/simkai.ttf");
	$t->setMaskFontSize(14);
	$t->setMaskFontColor("#000000");
	$t->setMaskTxtPct(20);
    // $t->setDstImgBorder(10,"#dddddd");
	$t->setDstImg(dirname(__FILE__).'/'.'out.jpg');
	$t->setMaskOffsetX(50);
	$t->setMaskOffsetY(308);
    // $text = "国权第三次";
    // $str = mb_convert_encoding($text, "UTF-8", "gb2312");
    // $t->setMaskWord($text);
	$t->setMaskWord("$liveYear   $liveMonth   $liveDay");
 
	// 指定固定宽高
	$t->createImg(100);

	// 死亡月
	$t2 = new ThumbHandler();
 
	$t2->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
	$t2->setMaskFont("upload/simkai.ttf");
	$t2->setMaskFontSize(14);
	$t2->setMaskFontColor("#000000");
	$t2->setMaskTxtPct(20);
    // $t2->setDstImgBorder(10,"#dddddd");
	$t2->setDstImg(dirname(__FILE__).'/'.'out.jpg');
	$t2->setMaskOffsetX(62);
	$t2->setMaskOffsetY(210);
	$t2->setMaskWord("$nowAge   $thisMonth");
	$t2->createImg(100);


    // 死亡时分秒
	$t3 = new ThumbHandler();
 
	$t3->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
	$t3->setMaskFont("upload/simkai.ttf");
	$t3->setMaskFontSize(14);
	$t3->setMaskFontColor("#000000");
	$t3->setMaskTxtPct(20);
	// $t2->setDstImgBorder(10,"#dddddd");
	$t3->setDstImg(dirname(__FILE__).'/'.'out.jpg');
	
	
	
	$t3->setMaskOffsetX(98);
	$t3->setMaskOffsetY(180);

	$t3->setMaskWord("$thisDay   24  $thisMoment   $thisSecond");
	$t3->createImg(100);
	
}
//发送图片微博
if(file_exists('out.jpg')){
	if(isset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]) && isset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET])){
	
		$result = OpenSDK_Tencent_Weibo::call('t/add_pic', array(
				'content' => "{$con}",
				'clientip' => '123.119.32.253',
			), 'POST', array(
			'pic' => array(
			'type' => 'image/jpg',
			'name' => '0.jpg',
			'data' => file_get_contents('out.jpg'),
			),
			)) ;
		print_r($result);
	}
}



?>
