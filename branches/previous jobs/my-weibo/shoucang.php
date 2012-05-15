<?php
include_once( 'modular/checklogin.php' );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<!--********11-19修改**********-->
	<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
	<!--********11-19修改**********-->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<title>新浪微博-by Micheal</title>
	
	<!--//png透明hack-->
	<!--[if IE 6]>
		<script src="js/png.js"></script>
		<script>
		  /* EXAMPLE */
		  DD_belatedPNG.fix('#sina_logo,#slogan,#send_button,#topbar');
		  
		  /* string argument can be any CSS selector */
		  /* .png_bg example is unnecessary */
		  /* change it to what suits you! */
		</script>
	<![endif]-->
</head>

<body>
		<!--div#header-->
		<?php require_once('modular/header.php');?>
		<!--end div#header-->
		
		
		
		<!--微博内容区域-->
		<div id="main">
		
			<!--导航栏：用来切换于微博和用户管理界面-->
			<div id="navi">
				<!--标签栏-->
				<!--********11-19修改**********-->
				<div id="tags">
					<span id="quanbu" class="tag nowfocus"><a href="weibolist.php">全部微博</a></span>
					<span id="haoyou" class="tag"><a href="guanzhu.php">关注</a></span>
					<span id="haoyou" class="tag"><a href="fensi.php">粉丝</a></span>
				</div>
				<!--********11-19修改**********-->
				
				
				<div id="tags_children"></div>
			</div>
			<!--end div#navi-->
			
			
			<!--微博内容区域
				每个微博有div.contentbox构成
				
				结构：
				div.contentbox{
								div.content-left -> a-> img(微博用户图片)
								
								div.content-right->{
													
													div.content_text(微博文字内容){
																
																				a(发微博用户名字)
													
													img(微博图片)
													
													div.content_info(微博信息：时间，发自哪里，评论收藏转发){
																							
																										a(发微博时间)
																										span->a(发微博设备)
					p.s. 有转发的微博和没转发的微博，区别在于有转发的
					在div.content-right里面多了个div.originaltweet
					里面是转发的微博内容，结构和div.contentbox的一样																					span.tweet_info->a*3 (评论 收藏 转发)			
			-->
			
			
			<div id="content">
			
				<?php   
					$ms  = $c->get_favorites($_GET['page'],MY_COUNT); // 读取用户收藏列表
					if( is_array( $ms['favorites'] ) ){
						foreach( $ms['favorites'] as $item ){
							if(isset($item['status']['deleted'])) continue;//屏蔽已经被原作者删除微博。
				?>
							
				<!-- div.contentbox-->
				<div class="contentbox">
					
					<!--左边部分，用来放发微博的用户照片-->
					<div class="content-left">
						<a href="http://weibo.com/<?php echo $item['status']['user']['id'] ;?>" target="_blank"><img src="<?php echo $item['status']['user']['profile_image_url'];?>" alt="" class="content_portrait" /></a>
					</div>
					
					<!--右边部分，这是个带转发的模板 class="no-retweet"-->
					<div class="content-right no-retweet">
					
						<!--微博的文字内容   <a>里面是用户名字 -->
						<div class="content_text">
							<span>
							
								<!--用户名字-->
								<a href="http://weibo.com/<?php echo $item['status']['user']['id']; ?>" target="_blank" class="userid"><?php echo $item['status']['user']['name'];?>:</a>
								
								<?php echo $c->text_to_bq($item['status']['text'],$bq);?></span>
						</div>
						
						<!--微博照片内容-->
						<?php 
						if(isset($item['status']['thumbnail_pic']))
							{ 
						?>
						<a href = "<?php echo $item['status']['original_pic'];?>" target = "_blank"><img src="<?php echo $item['status']['thumbnail_pic'];?>" alt="" class="content_img" /></a>
						<?php
							}
						?>
						
						
						<?php   
							if( isset( $item['retweeted_status'] ) ){
						?>
						<!--微博转发内容-->
						<div class="originaltweet">
							<span class="retweet"><a href="" class="userid">@<?php echo $item['status']['retweeted_status']['user']['name'];?>：</a><?php echo $item['status']['retweeted_status']['text'];?></span>
							
							<?php   
							if( isset( $item['retweeted_status']['thumbnail_pic']) ){
							?>
							<a href="<?php echo $item['retweeted_status']['original_pic'];?>" target = "_blank"><img src="<?php echo $item['retweeted_status']['thumbnail_pic'];?>" alt="" class="retweet_content_img" /></a>
							<?php 
							}
							?>
						
							<div class="retweet_content_info">
								<span class="tweet_info">
									<a href="http://weibo.com/<?php echo $item['retweeted_status']['user']['id'] ;?>" target="_blank">转发(<?php echo $item['retweeted_status']['comments_count'];?>)</a>
									<a href="?shoucang=<?php echo $item['retweeted_status']['mid'] ;?>">收藏</a>
									<a href="http://weibo.com/<?php echo $item['retweeted_status']['user']['id']; ?>" target="_blank">评论(<?php echo $item['retweeted_status']['reposts_count'];?>)</a>
								</span>
							</div>
						</div>
						<!--end div.originaltweet-->
						
						<?php 
						}
						?>
				
						
						
						
						
						<!--微博的详细信息-->
						<div class="content_info">
							<!--发表时间-->
							<!--<a href="">15分钟前</a>-->
							
							<!--来源-->
							<span>来自<?php echo$item['status']['source'];?></span>
							
							<!--转发，收藏和评论-->
							<span class="tweet_info">
								<a href="http://weibo.com/<?php echo $item['status']['user']['id']; ?>" target="_blank">转发(<?php echo $item['status']['comments_count'];?>)</a>
								<a href="?quxiaoshoucang=<?php echo $item['status']['mid'] ;?>">取消收藏</a>
								<a href="http://weibo.com/<?php echo $item['status']['user']['id'] ;?>" target="_blank">评论(<?php echo $item['status']['reposts_count'];?>)</a>
							</span>
							
						</div>
						<!--end div.content_info-->
					</div>
					<!--div#content-right-->	
				</div>
				<!--end div#contentbox-->
				<?php 
						}
					}
				?>
			</div>
			<!--end div#content-->
		</div>
		<!--end div#main-->
		
		<!-- div#page--分页导航-->
		<div id = "page">
		<a href = "?page=<?php echo $_GET['page']>1?$_GET['page']-1:1;?>"><span>上一页</span></a>
		<a href = "?page=<?php echo $_GET['page']+1;?>"><span>下一页</span></a>
		<!-- end div#page-->
	</div>
	<!--end div#container-->
	
	<!--********11-19修改**********-->
	<script type="text/javascript" src="js/main.js"></script>
	<!--********11-19修改**********-->
</body>
</html>













