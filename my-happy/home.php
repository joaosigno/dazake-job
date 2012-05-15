<?php
//登陆校验
require_once('./modular/checklogin.php');
//引入数据生成文件
require_once('./modular/md_home.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/common.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/reset.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/home.css" media="all" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<title>开心网-Dazake</title>
</head>
<body>
	<!--div#container-->
	<div id="container">
		<?php include_once('./modular/header.php');?>
		
		<!--div#main-->
		<div id="main">
			<!--div#msg_navi-->
			<div id="msg_navi">
				<a href="#" class="msg_navi msg_current" id="msg_home">全部动态</a>
				<a href="my_status.php"  class="msg_navi" id="msg_mine">我的动态</a>
			</div>
			<!--end div#msg_navi-->
			
			<!--消息内容区-->
			<!--news_content-->
			<div id="news_content">
				<!--each_news   !!!记录-->
				<div class="each_news">
					<div class="news_left">
						<!--区别不同内容的图标-->
						<img src="img/status.png" alt="" class="news_type_status" />
					</div>
					<div class="news_right">
						<div class="news_content">
							<!--好友名字-->
							<a href="" class="news_user_name">BY2:</a>
							<!--消息的文字内容-->
							<span class="news_text">挖～都快破1萬剌 &quot;白兔乖乖&quot;喔！你們總是不離不棄 緊緊跟隨～～～謝謝你們無盡無休的愛 送一張Miko偷拍我白天偷打瞌睡 可惡！ 自從去年在紐約機場的&quot;拜拜睡姿&quot;後 現在有個進階版 &quot;折疊睡姿&quot;！！怎墨感覺像睡姿專家惹 看看我睡覺是多麼沒安全感惹 抱抱 Yumi 
							</span>
						</div>
						<!--消息的图片内容-->
						<a href="img/sample.jpeg" target="_blank"><img src="img/sample.jpeg" alt="" class="news_pic" /></a>
						<!--转发评论-->
						<div class="news_info">
							<span class="retweet">转发(2)</span>
							<span class="comment">评论</span>
							<span class="like">赞</span>
						</div>
					</div>
				</div>
				<!--end each_news-->
				
				<!--each_news  !!!!照片-->
				<div class="each_news">
					<div class="news_left">
						<img src="img/photos.png" alt="" class="news_type_photo" />
					</div>
					<div class="news_right">
						<div class="news_content">
							<!--用户名-->
							<a href="" class="news_user_name">李连杰</a>
							<span class="news_text">上传了<span>5</span>张新照片至</span>
							<a href="" class="photo_album">武当山之行</a>
						</div>
						<!--照片连接-->
						<a href="http://pic1.kaixin001.com.cn/pic/photo/36/59/41244293_757365993_mid.jpg" target="_blank">
							<img src="http://pic1.kaixin001.com.cn/pic/photo/36/59/41244293_757365993_mid.jpg" alt="" class="news_pic" /></a>
						<a href="http://pic1.kaixin001.com.cn/pic/photo/36/69/41244293_757366977_mid.jpg" target="_blank">
							<img src="http://pic1.kaixin001.com.cn/pic/photo/36/69/41244293_757366977_mid.jpg" alt="" class="news_pic" /></a>
						<a href="http://pic1.kaixin001.com.cn/pic/photo/36/77/41244293_757367751_mid.jpg" target="_blank">
							<img src="http://pic1.kaixin001.com.cn/pic/photo/36/77/41244293_757367751_mid.jpg" alt="" class="news_pic" /></a>
						<!--转发评论-->
						<div class="news_info">
							<span class="retweet">转发(2)</span>
							<span class="comment">评论(22)</span>
							<span class="like">赞</span>
						</div>
					</div>
				</div>
				<!--end each_news-->
				
				<!--each_news   !!!转帖（只有链接）-->
				<div class="each_news">
					<div class="news_left">
						<img src="img/retweet.png" alt="" class="news_type_status" />
					</div>
					<div class="news_right">
						<div class="news_content">
							<a href="" class="news_user_name">贾翠儿</a>
							<span class="news_text">转帖给大家：</span>
						</div>
						<div class="share_links">
						<a href="" target="_blank">聊聊美剧常规“剧情手法”  </a>
						<a href="" target="_blank">《后宫甄嬛传》热播 刘雪华被封“最佳太后”  </a>
						<a href="" target="_blank">山东等地大雪降温 内蒙局地零下39度  </a>
						<a href="" target="_blank">欧洲杯足球宝贝全裸特辑  </a>
						<a href="" target="_blank">杨澜告诫女孩：二十几岁的女孩应该拥有以下的... </a>
						<a href="" target="_blank">让你目不暇接的大片，那眩目的视觉效果根本的... </a>
						</div>
					</div>
				</div>
				<!--end each_news-->
				
				<!--each_news   !!!转帖（有链接和视频）-->
				<div class="each_news">
					<div class="news_left">
						<img src="img/retweet.png" alt="" class="news_type_status" />
					</div>
					<div class="news_right">
						<div class="news_content">
							<a href="" class="news_user_name">贾翠儿</a>
							<span class="news_text">转帖给大家：</span>
						</div>
						<div class="share_links">
						<!--视屏截图-->
							<div class="share_pattern">
								<a href="" target="_blank"><img src="http://p1.v.iask.com/776/5/67106180_1.jpg" alt="" /></a>
								<a href="" target="_blank">CBS Holiday Seaso...</a>
							</div>
						<!--视屏截图-->
							<div class="share_pattern">
								<a href=""><img src="http://i1.tdimg.com/114/340/050/p.jpg" alt="" /></a>
								<a href="" target="_blank">少年，究竟是谁深... </a>
							</div>
						</div>
					</div>
				</div>
				<!--end each_news-->
				
			</div>
			<!--end news_content-->
		</div>
		<!--end div#main-->
		<?php include_once('./modular/footer.php');?>
	</div>
</body>
</html>
