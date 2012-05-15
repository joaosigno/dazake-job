<?php
include_once( 'modular/checklogin.php' );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/contact.css" media="all" />
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
					<span id="quanbu" class="tag"><a href="weibolist.php">全部微博</a></span>
					<span id="haoyou" class="tag"><a href="guanzhu.php">关注</a></span>
					<span id="haoyou" class="tag nowfocus"><a href="fensi.php">粉丝</a></span>
				</div>
				<!--********11-19修改**********-->
				
				
				<div id="tags_children"></div>
			</div>
			<!--end div#navi-->
			<!--粉丝部分-->
			<div id="contact">
				<!--每一个好友一个contact_box-->
				<?php   
					//获取用户粉丝
					$fs  = $c->followers_by_id($uid,$_GET['page'],MY_COUNT); // done
					if( is_array( $fs['users'] ) ){
						foreach( $fs['users'] as $item ){
				?>
				<div class="contact_box">
					<!--左边：头像，是否互粉，添加关注-->
					<div class="contact_box_left">
						<!--头像-->
						<img src="<?php echo $item['profile_image_url'];?>" alt="" class="contact_portrait" />

						<?php
						$ship = array();
						$ship = $c->is_followed_by_id($item['id']);
						if($ship['source']['following']){
							echo '<div class="contact_relationship"></div>';//互粉
						}else{
							echo '<div class="contact_cancel"><a href="?fsid='.$item['id'].'">加关注</a></div>';//添加关注
						}
						?>
						
						
					</div>	
					
					<!--右边：用户名，性别，地址，最新一条微博-->
					<div class="contact_box_right">
						<!--用户名-->
						<div class="contact_name"><a href=""><?php echo $item['name'];?></a></div>
						<!--性别，地址-->
						<span class="contact_sex"></span><span class="contact_address"><?php echo $item['location'];?></span><span class="contact_detail">粉丝(<?php echo $item['followers_count'];?>)</span>
						<!--个人说明-->
						<div class="contact_newest_weibo"><a href="">个人说明：<?php echo $item['description']!=''? $item['description']:'对方很懒，什么都没说';?></a></div>
					</div>
				</div>
				
				<?php 
						}
					}
				?>
				
				
			</div>
			<!--end contact-->
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
	
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		$('.contact_box').mouseover(function () {
			var contactCancel = $(this).children('.contact_box_left').children('.contact_cancel').children()
			contactCancel.css('visibility','visible');
		})
		
		$('.contact_box').mouseout(function () {
			var contactCancel = $(this).children('.contact_box_left').children('.contact_cancel').children()
			contactCancel.css('visibility','hidden');
		})
	</script>
</body>
</html>













