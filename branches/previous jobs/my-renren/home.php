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
	<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<title></title>
</head>
<body>
	<!--div#container-->
	<div id="container">
		<!--div#header-->
		<?php include_once('./modular/header.php');
		//新鲜事保存在$xinxian数组里面
		$xinxian = $client->POST('feed.get',array($_GET['page'], MESSAGE_COUNT,'10,20,21,30,32,33,50,51,52,')); 	
		?>
		<!--end div#header-->
		<!--div#main-->
		<div id="main">
			<!--div#news_box包裹所有新鲜事-->
			<div id="news_box">
			<?php
				foreach($xinxian as $item) {
			?>
				<!--div.each_news每一天新鲜事-->
				<div class="each_news">
					<div id="comment_share_success_float_box" class="comment_share_success_float_box hide">分享成功</div>
					<div class="comment_success_float_box comment_share_success_float_box hide">评论成功</div>
					<div class="col-left">
						<!--当前用户照片-->
						<img src="<?php echo $item['headurl'] ;?>" alt="" class="fds_portrait" />
						
					</div>
					
					<div class="col-mid">
						<div class="news_content">
							<!--喜欢传递的url<?php echo $item['href'] ;?>-->
							<!--判断用户是否喜欢<?php echo $item['likes']['user_like'] ;?>-->
							<!--当前用户姓名&新鲜事的题目-->
							<span class="news_title"><a href="" class="fds_name"><?php echo $item['name'] ;?>	:</a><?php if(isset($item['message'])) echo text_to_bq($item['message'],$bq);else echo $item['prefix'];?><?php if(isset($item['title'])) echo $item['title'];?></span>
							<!--新鲜事的文字部分-->
							<div class="text_content"><?php if(isset($item['description'])) echo $item['description'];?></div>
							<!--新鲜事的图片部分-->
							<div class="pic_content">
							<?php if(isset($item['attachment'])){ 
								foreach($item['attachment'] as $attachment){
									$str_href = '';
									$str_src = '';
									if(isset($attachment['href']))
										$str_href = $attachment['href'];
									if(isset($attachment['src']))
										$str_src = $attachment['src'] ;
									echo '<a target = "_blank" href = "'.$str_href.'"><img src="'.$str_src.'" alt="" /></a>';				
								}
							}
							?>
							</div>
						</div>
						
						<!--收起，分享，喜欢按钮-->
						<div class="news_info">
							<span class="close_comment">收起</span>
							<span <?php if (isCanLike($item) == "0") {echo " class='share_news hide'";}else{echo " class='share_news'";}?> alt="<?php echo $item['href']?>">分享</span>
							<div class="isLike hide" alt=""></div>
							<span class="like_button<?php if (isCanLike($item) == "0") {echo 'hide';}?>"><span class="<?php if (isCanLike($item) == "0") {echo 'hide';}?>"><?php if ($item['likes']['user_like'] == "0") {echo '喜欢';}else{echo '取消';}?></span></span>	
						</div>
						
						<!--评论部分-->
						<div class="news_comment_box">
							<div class="share_float_box hide">
								<textarea name="" id="" cols="30" rows="10" class="share_float_box_url"></textarea>
								<div class="share_float_box_cancel">取消</div>
								<div class="share_float_box_send">发布</div>
							</div>
							
							<div <?php if ($item['likes']['user_like'] == "0") {echo "class='like_status hide'";}else{echo "class='like_status'";}?>>
								<span class="like_status_button"></span>
								<span>我很喜欢！</span>
							</div>
							<!--div.news_comment_area包裹着所有评论-->
							<div class="news_comment_area">
								<!--div.each_news_comment每一条评论-->
								<?php
									if(isset($item['comments']['comment'])){ 
										foreach($item['comments']['comment'] as $comment){
											echo '<div class="each_news_comment">';
										// 评论者的照片
											echo '<img src="'.$comment['headurl'].'" alt="img/user_portrait.jpg" class="comment_fds_portrait" />';
										// 评论者的名字
											echo '<div class="comment_fds_name"><a href="">'.$comment['name'].'：</a></div>';
										// 评论内容
											echo '<div class="comment_content">'.text_to_bq($comment['text'],$bq).'</div>';
											echo '</div>';
										}
									}
								?>
							</div>
							<!--发表评论框-->
							<!--图片所有者id<?php if(isset($item['attachment'])) echo $item['actor_id']?>-->
							<!--图片id<?php if(isset($item['attachment'])) echo $item['attachment'][0]['media_id']?>-->
							<div class="insert_comment_box">
								<form action="">
									<?php echo show_comment_data($item);?>
									<textarea name="" class="insert_comment_text" cols="30" rows="10" maxlength="140"></textarea>
									<div class="insert_comment_button">提交</div>
								</form>
								<!--表情触发-->
									<div class="comment_biaoqing"><span class="comment_biaoqing_logo"></span>表情</div>
									
									
									<div class="comment_biaoqing_float_box" title="hide">
										<div class="comment_biaoqing_corner">♦</div>
										<ul>
											<?php
												foreach($bq as $item){
													echo '<li class="comment_biaoqing_icon"><img src="'.$item['icon'].'" alt="'.$item['emotion'].'" /></li>';
												}
											?>
										</ul>
									</div>
									
								</div>
								<!--div#publisher发信息框-->
							</div>
						<!--评论部分-->
					</div>
				</div>
				<!--end div.each_news每一天新鲜事-->
				<?php
					}
				?>
				
			</div>
			<!--end div#news_box包裹所有新鲜事-->
			
				
		</div>
		<!--end div#main-->
		<!--div#footer-->
		<div id="footer">
			<!-- div#nav_page--分页导航-->
			<div id = "nav_page">
			<a href = "?page=<?php echo $_GET['page']>1?$_GET['page']-1:1 ;?>"><span>上一页</span></a>
			<a href = "?page=<?php echo $_GET['page']+1 ;?>"><span>下一页</span></a>
			</div>
			<!-- end div#nav_page-->
		</div>
		<!--end div#footer-->
		

	</div>
	<!--end div#container-->
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		//新鲜事喜欢功能
		$('.like_button span').click(function () {
			var kkk = $(this);
			var newThis = kkk.parents('.news_info').siblings('.news_comment_box');
			var newNewThis = newThis.children('.insert_comment_box').children('form').children('.comment_ajax');
			var type = newNewThis.children('.type').html();
			var ownerId = newNewThis.children('.owner_id').html();
			var srcId = newNewThis.children('.src_id').html();
			var isLike;
			if(kkk.html() == "喜欢")
			{
				$.ajax({
					type:"POST",
					url:ajaxLike,
					data:{type:type,ownerId:ownerId,srcId:srcId,isLike:"0"},
					beforeSubmit:function () {},
					success:function (data) {
						kkk.html('取消');
						newThis.children('.like_status').removeClass('hide');				
					}
				})
			}
			else
			{
				$.ajax({
					type:"POST",
					url:ajaxLike,
					data:{type:type,ownerId:ownerId,srcId:srcId,isLike:"1"},
					beforeSubmit:function () {},
					success:function (data) {
						kkk.html('喜欢');
						newThis.children('.like_status').addClass('hide');
					}
				})
			}
		})
		
		
		//新鲜事分享功能
		$('.share_news').click(function () {
			$(this).parents('.news_info').siblings('.news_comment_box').children('.share_float_box').removeClass('hide');
		})
		
		$('.share_float_box_cancel').click(function () {
			$(this).parent('.share_float_box').addClass('hide');
			$(this).siblings('textarea').attr('value','');
		})
		
		$('.share_float_box_send').click(function () {
			var newThis = $(this);
			var kkk = newThis.parents('.share_float_box').siblings('.insert_comment_box').children('form').children('.comment_ajax');
			var commentShareType = kkk.children('.type').html();
			var commentShareOwnId = kkk.children('.owner_id').html();
			var commentShareSrcId = kkk.children('.src_id').html();
			var commentShareContent = newThis.siblings('textarea').val();
			$.ajax({
				type:"POST",
				url:ajaxShare,
				data:{commentShareType:commentShareType,commentShareOwnId:commentShareOwnId,commentShareSrcId:commentShareSrcId,commentShareContent:commentShareContent},
				beforeSubmit:function () {},
				success:function (data) {
					newThis.parents('.each_news').children('#comment_share_success_float_box').fadeIn('5000').fadeOut('5000');
					newThis.parent('.share_float_box').addClass('hide');
					newThis.siblings('textarea').attr('value','');	
				}
			})
		})
		
		//发表评论
		$(function () {
			$('.insert_comment_button').click(function () {
				var This = $(this);
				var newThis = $(this).siblings('.comment_ajax');
				var type = newThis.children('.type').html();
				var ownerId = newThis.children('.owner_id').html();
				var srcId = newThis.children('.src_id').html();
				var comment = $(this).siblings('.insert_comment_text').val();
				$.ajax({
					type:"POST",
					url:ajaxAddComment,
					data:{type:type,ownerId:ownerId,srcId:srcId,comment:comment},
					beforeSubmit:function () {},
					success:function (data) {
						This.siblings('.insert_comment_text').attr('value','');
						newThis.parents('.each_news').children('.comment_success_float_box').fadeIn('5000').fadeOut('5000');
							This.parents('.insert_comment_box').siblings('.news_comment_area').append("<div class='each_news_comment'><img src='<?php echo $us[0]['headurl'] ;?>' alt='img/user_portrait.jpg' class='comment_fds_portrait' /><div class='comment_fds_name'><a href=''><?php echo $us[0]['name'];?> :</a></div><div class='comment_content'>"+comment+"</div></div>");		
					}
				})
			})
		})
	</script>
</body>
</html>