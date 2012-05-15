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
					$ms  = $c->user_timeline_by_id($uid,$_GET['page'],MY_COUNT); // 用户发布的微博信息列表
					if( is_array( $ms['statuses'] ) ){
						foreach( $ms['statuses'] as $item ){
				?>
							
				<!-- div.contentbox-->
				<div class="contentbox">
					
					<!--左边部分，用来放发微博的用户照片-->
					<div class="content-left">
						<a href="http://weibo.com/<?php echo $item['user']['id'] ;?>" target="_blank"><img src="<?php echo $item['user']['profile_image_url'];?>" alt="" class="content_portrait" /></a>
					</div>
					
					<!--右边部分，这是个带转发的模板 class="no-retweet"-->
					<div class="content-right no-retweet">
					
						<!--微博的文字内容   <a>里面是用户名字 -->
						<div class="content_text">
							<span>
							
								<!--用户名字-->
								<a href="http://weibo.com/<?php echo $item['user']['id']; ?>" target="_blank" class="userid"><?php echo $item['user']['name'];?>:</a>
								
								<?php echo $c->text_to_bq($item['text'],$bq);?></span>
						</div>
						
						<!--微博照片内容-->
						<?php 
						if(isset($item['thumbnail_pic']))
							{ 
						?>
						<a href = "<?php echo $item['original_pic'];?>" target = "_blank"><img src="<?php echo $item['thumbnail_pic'];?>" alt="" class="content_img" /></a>
						<?php
							}
						?>
						
						
						<?php   
							if( isset( $item['retweeted_status'] ) ){
						?>
						<!--微博转发内容-->
						<div class="originaltweet">
							<span class="retweet"><a href="" class="userid">@<?php echo $item['retweeted_status']['user']['screen_name'];?>：</a><?php echo $item['retweeted_status']['text'];?></span>
							
							<?php   
							if( isset( $item['retweeted_status']['thumbnail_pic']) ){
							?>
							<a href="<?php echo $item['retweeted_status']['original_pic'];?>" target = "_blank"><img src="<?php echo $item['retweeted_status']['thumbnail_pic'];?>" alt="" class="retweet_content_img" /></a>
							<?php 
							}
							?>
						
							
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
							<span>来自<?php echo $item['source'];?></span>
							
							<!--转发，收藏和评论-->
							<span class="tweet_info">
								<span class="insert_retweet_button" alt="<?php echo $item['mid'] ;?>">转发(<?php echo $item['comments_count'];?>)</span>
								<a href="?shanchu=<?php echo $item['mid'] ;?>">删除</a>
								<span class="insert_comment_button" alt="<?php echo $item['mid'] ;?>">评论(<?php echo $item['reposts_count'];?>)</span>
							</span>
						</div>
						
						<!--end div.content_info-->
						
						<!--retweetbox-->
						<div class="retweetbox hide" alt="<?php echo $item['mid'] ;?>">
							<form action="">
								<textarea name="" class="retweet_box_text" id="" cols="30" rows="10"></textarea>
								<div class="retweet_box_button">转发</div>
							</form>
							
							<div class="retweet_biaoqing">
								<span class="retweet_biaoqing_trigger"></span>
							</div>
							<div class="retweet_biaoqing_floatbox hide">
								<ul>
									<?php
										for($i=0;$i<64;$i++){
										echo '<li class="retweet_biaoqing_img"><img src="'.$bq[$i]['icon'].'" alt="'.$bq[$i]['phrase'].'" /></li>';
										}
									?>
								</ul>
							</div>
						</div>
						<!--end retweetbox-->
						
						<!--commentbox-->		
						<div class="commentbox hide" alt="<?php echo $item['mid']; ?>">
							
						</div>
						<!--end commentbox-->
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
		</div>
		<!-- end div#page-->
	</div>
	<!--end div#container-->
	
	<!--********11-19修改**********-->
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/comment.js"></script>
	<!--********11-19修改**********-->
</body>
</html>













