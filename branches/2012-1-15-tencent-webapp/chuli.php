<?php
$_POST['nickname'] = 'micheal测试';
// $_POST['username'] = '红红';
$_POST['head'] = 'http://app.qlogo.cn/mbloghead/bdb750b150f9d7fb4c8a/50';
// $_POST['gz'] = 1 ;是否关注

session_start();
set_include_path(dirname(__FILE__) . '/class/');
error_reporting('0');
require_once 'OpenSDK/Tencent/Weibo.php';
include 'class/appkey.php';
include 'class/config.php';
OpenSDK_Tencent_Weibo::init($appkey, $appsecret);
header('Content-Type: text/html; charset=utf-8');
require_once('class/thumb.class.php');

//图片处理
if(isset($_POST['nickname']) && isset($_POST['head']) ){
	
	//获取图片函数
	function getImg($url = "", $filename = "") { 
		if(is_dir(basename($filename))) { 
			echo "The Dir was not exits"; 
			Return false; 
		}
		$url = preg_replace( '/(?:^[\'"]+|[\'"\/]+$)/', '', $url ); 
		$hander = curl_init(); 
		$fp = fopen($filename,'wb'); 
		curl_setopt($hander,CURLOPT_URL,$url); 
		curl_setopt($hander,CURLOPT_FILE,$fp); 
		curl_setopt($hander,CURLOPT_HEADER,0); 
		curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($hander,CURLOPT_TIMEOUT,60); 
		curl_exec($hander); 
		curl_close($hander); 
		fclose($fp); 
		Return true; 
	} 
	//下载图片
	$filename = 'qqhead.jpg';
	$url = $_POST['head']; 
	getImg($url, $filename); 
	
	if(file_exists('qqhead.jpg')){
		
	    //头像下载回来继续处理
		
		$b = imagettfbbox(14,0,"upload/fangzheng.ttf",$_POST['nickname']);//文字宽度
		$w = abs($b[2] - $b[0]);
		
		$t = new ThumbHandler();
		$t->setSrcImg("images/show.jpg");
		$t->setDstImg("out.jpg");
		$t->setMaskImg("qqhead.jpg");
		$t->setMaskOffsetX(($t->src_w + $w )/2 + 20);
		$t->setMaskOffsetY($t->src_h -150);
		$t->setMaskImgPct(100); 
		$t->createImg(100);// 指定缩放比例
		
		
		// 第二个水印 名字
		$t2 = new ThumbHandler();
		$t2->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
		$t2->setMaskFont("upload/fangzheng.ttf");
		$t2->setMaskFontSize(16);
		$t2->setMaskFontColor("#1A6BE6");
		$t2->setMaskTxtPct(20);
		$t2->setDstImg(dirname(__FILE__).'/'.'out.jpg');
		$t2->setMaskOffsetX(($t->src_w - $w )/2);
		$t2->setMaskOffsetY($t2->src_h + $t2->font_h - 150);
		$t2->setMaskWord($_POST['nickname']);
		$t2->createImg(100);
		
		
		//循环处理字体
		$end =  count($con_arr) -1;
		foreach($con_arr[rand(0,$end)] as $key => $item){
	
			$con = $item;
			$b = imagettfbbox(14,0,"upload/fangzheng.ttf",$con);
			$w = abs($b[2] - $b[0]);
			$h = abs($b[7] - $b[1]);
			$t3 = new ThumbHandler();
			$t3->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
			$t3->setMaskFont("upload/fangzheng.ttf");
			$t3->setMaskFontSize(14);
			$t3->setMaskFontColor("#c40219");
			$t3->setMaskTxtPct(20);
			$t3->setDstImg(dirname(__FILE__).'/'.'out.jpg');	
			$t3->setMaskOffsetX($t->src_w - $w -60);
			$t3->setMaskOffsetY($t->src_h -300 - ($key*($h+10)));
			$t3->setMaskWord($item);
			$t3->createImg(100);
		}
		
		// 第四个水印日起
		$da = "2012-".rand(2,12) ."-".rand(1,28)."";
		$b = imagettfbbox(14,0,"upload/fangzheng.ttf",$da);//文字宽度
		$w = abs($b[2] - $b[0]);
		
		$t4 = new ThumbHandler();
		$t4->setSrcImg(dirname(__FILE__).'/'.'out.jpg');
		$t4->setMaskFont("upload/fangzheng.ttf");
		$t4->setMaskFontSize(46);
		$t4->setMaskFontColor("#13dd51");
		$t4->setMaskTxtPct(20);
		$t4->setDstImg(dirname(__FILE__).'/'.'out.jpg');	
		$t4->setMaskOffsetX(($t4->src_w - $w -170)/2);
		$t4->setMaskOffsetY($t4->src_h -280);
		$t4->setMaskWord($da);
		$t4->createImg(100);
	}	
}

//发送图片微博
if(file_exists('out.jpg')  ){
	if(isset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]) && isset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET])){
	
		$result = OpenSDK_Tencent_Weibo::call('t/add_pic', array(
				'content' => $message,//这里读取内容
				'clientip' => '123.119.32.253',
			), 'POST', array(
			'pic' => array(
			'type' => 'image/jpg',
			'name' => '0.jpg',
			'data' => file_get_contents('out.jpg'),//这里读取图片
			),
			)) ;
			
		// 如果不要加关注作者，把下面语句注译去掉
		if($_POST['gz'])
			$friendadd = OpenSDK_Tencent_Weibo::call('friends/add',array('name' => CREATER),'post');	
		
		if($result)
			header("Location: last.php");
	}
}

?>
