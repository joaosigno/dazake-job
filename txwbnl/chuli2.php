<?php
//$_POST['guanzhu'] 是否关注：1：关注，0：不关注	

session_start();
set_include_path(dirname(__FILE__) . '/class/');
error_reporting('0');
require_once 'OpenSDK/Tencent/Weibo.php';
include 'class/appkey.php';
OpenSDK_Tencent_Weibo::init($appkey, $appsecret);
$uinfo = OpenSDK_Tencent_Weibo::call('user/info');
// $userinfo = $uinfo['data']['nick'];
header('Content-Type: text/html; charset=utf-8');
require_once('class/thumb.class.php');

//图片处理
	$nowAge = $_POST['nowAge'] = 2;
	$nowAge = $_POST['thisMonth'] = 2;
	$nowAge = $_POST['thisDay'] = 2;
	$nowAge = $_POST['thisMoment'] = 2;
	$nowAge = $_POST['thisSecond'] = 2;
	$userinfo = "Micheal";


	//剩余的年：
	$nowAge = $_POST['nowAge'] > 9 ? $_POST['nowAge'] : '0'.$_POST['nowAge'];
	//剩余的月：
	$thisMonth = $_POST['thisMonth'] > 9 ? $_POST['thisMonth'] : '0'.$_POST['thisMonth'];
	//剩余的日：
	$thisDay = $_POST['thisDay'] > 9 ? $_POST['thisDay'] : '0'.$_POST['thisDay']; 
	//剩余的时：
	$thisHour = time()%24;
	$thisHour = $thisHour > 9 ? $thisHour : '0'.$thisHour;
	//剩余的分：
	$thisMoment = $_POST['thisMoment'] > 9 ? $_POST['thisMoment'] : '0'.$_POST['thisMoment'];
	//剩余的秒：
	$thisSecond = $_POST['thisSecond'] > 9 ? $_POST['thisSecond'] : '0'.$_POST['thisSecond'];
	
    // 活着的年
	$liveYear = $_POST['nowAge'] + date("Y");
    // 活着的月
	$liveMonth = ($_POST['thisMonth'] + date("m"))%12;
	$liveMonth = $liveMonth > 9 ? $liveMonth : '0'.$liveMonth;
    // 活着的日
	$liveDay = ($_POST['thisDay'] +  date("d"))%28 ;
	$liveDay = $liveDay > 9 ? $liveDay : '0'.$liveDay;
	
    // 用户昵称
	$userinfo = $uinfo['data']['nick'];

	
	//文字像素宽度
	$b = imagettfbbox(14,0,"upload/simkai.ttf",$userinfo);
	$w = abs($b[2] - $b[0]);
	
	//发送微博内容
	$con = "经过科学标准测试，我居然还可以活 {$nowAge} 年！你知道你还能活多少年吗？完成24个专业测试题就能鉴定出，快来试试吧！#测试你的寿命#";
	
	//一共3个水印时间。分三次写。
	// 你将于公元多少年多少月多少日去世
	$con1 = "{$liveYear}    {$liveMonth}   {$liveDay}   ";
	// 你距离死亡时间还有多少年多少月
	$con2 = "{$nowAge}    {$thisMonth}   {$thisDay}    ";
	// 你距离死亡时间还有多少日多少时多少分多少秒
	$con3 = "{$thisHour}    {$thisMoment}   {$thisSecond}    ";
	//生成图片
if(isset($_POST['nowAge'])){
 	// 第一个水印
	$t = new ThumbHandler();
	$t->setSrcImg("upload/lifetest.jpg");//水印原图
	$t->setMaskFont("upload/simkai.ttf");//字体文件，如果要用其他字体，把字体文件放在upload文件夹，修改对应值。注意有些字体不支持中文
	$t->setMaskFontSize(14);//字体大小修改
	$t->setMaskFontColor("#1A6BE6");//字体颜色修改
	$t->setMaskTxtPct(20);
	$t->setDstImg(dirname(__FILE__).'/'.'out.jpg');
	$t->setMaskOffsetX(28); //水印横坐标
	$t->setMaskOffsetY(270);//水印纵坐标
	$t->setMaskWord($con1); //水印文字内容在这里加进去
	$t->createImg(100); //生成水印目标图片

	 // 第二个水印
	$t2 = new ThumbHandler();
	$t2->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
	$t2->setMaskFont("upload/simkai.ttf");
	$t2->setMaskFontSize(14);
	$t2->setMaskFontColor("#1A6BE6");
	$t2->setMaskTxtPct(20);
	$t2->setDstImg(dirname(__FILE__).'/'.'out.jpg');
	$t2->setMaskOffsetX(80);
	$t2->setMaskOffsetY(144);
	$t2->setMaskWord($con2);
	$t2->createImg(100);


	// 第三个水印
	$t3 = new ThumbHandler();
	$t3->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
	$t3->setMaskFont("upload/simkai.ttf");
	$t3->setMaskFontSize(14);
	$t3->setMaskFontColor("#1A6BE6");
	$t3->setMaskTxtPct(20);
	$t3->setDstImg(dirname(__FILE__).'/'.'out.jpg');	
	$t3->setMaskOffsetX(81);
	$t3->setMaskOffsetY(111);
	$t3->setMaskWord($con3);
	$t3->createImg(100);
	
	// 第四个水印
	// $uinfo = OpenSDK_Tencent_Weibo::call('user/info');
	$t4 = new ThumbHandler();
	$t4->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
	$t4->setMaskFont("upload/simkai.ttf");
	$t4->setMaskFontSize(14);
	$t4->setMaskFontColor("#FF0000");
	$t4->setMaskTxtPct(20);
	$t4->setDstImg(dirname(__FILE__).'/'.'out.jpg');	
	$t4->setMaskOffsetX(150-$w/2);
	$t4->setMaskOffsetY(308);
	$t4->setMaskWord($userinfo);
	$t4->createImg(100);

	
}
//发送图片微博
if(file_exists('out.jpg')){
	if(isset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]) && isset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET])){
	
		$result = OpenSDK_Tencent_Weibo::call('t/add_pic', array(
				'content' => "{$con}",//这里读取内容
				'clientip' => '123.119.32.253',
			), 'POST', array(
			'pic' => array(
			'type' => 'image/jpg',
			'name' => '0.jpg',
			'data' => file_get_contents('out.jpg'),//这里读取图片
			),
			)) ;
			
			// echo $uinfo['name'];
			
		// 如果不要加关注作者，把下面语句注译去掉
		if($_POST['guanzhu'])
			$friendadd = OpenSDK_Tencent_Weibo::call('friends/add',array('name' => 'nacheal1989'),'post');	
			// echo $_POST['guanzhu'];	
			
		
		print_r($result);
	}
}



?>
