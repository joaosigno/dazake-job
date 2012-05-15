<?php
//更新状态
	if(isset($_REQUEST['text'])){
		$result = $client->POST('status.set',array($_REQUEST['text'])); //
		include_once('./class/db.class.php');
		$db = new DB();
		$sql_arr = array();
		$sql_arr['w_id'] = $_SESSION['id'];	
		$sql_arr['type'] = 'statu';		
		$sql_arr['prefix'] = $_REQUEST['text'];		
		$sql_arr['messages'] = $_REQUEST['text'];		
		$sql_arr['addTime'] = time();			
		$db->insert(DB_TABLE_PREFIX.'renren_message',$sql_arr);
	}
?>

<div id="header">
<!--div#navi头部顶栏-->
<div id="navi">
	<!--头像-->
				<img src = "<?php echo $us[0]['headurl'];?>" alt="" id="portrait" />
				
				<div id="logout">
					<!--用户名-->
					<div id="user_name"><?php echo $us[0]['name'];?></div>
					<!--退出登陆-->
					<div id="logo_out"><span id="logo"></span><a href="modular/logout.php">退出</a></div>
				</div>
				<div id="nav">
					<!--导航栏-->
					<a href="<?php echo WEB_SIZE.'home.php';?>">首页</a>
					<a href="<?php echo WEB_SIZE.'myhome.php';?>">个人主页</a>
					<a href="<?php echo WEB_SIZE.'haoyou.php';?>">好友</a>
				</div>
			</div>
			<!--end div#navi头部顶栏-->
			
			<!--div#publisher发信息框-->
			<div id="publisher">
				<div id="send_success_float_box" class="hide">发布成功</div>
				<div id="uploading_status" class="hide"><img src="img/loading22.gif" alt="" />正在上传，请稍等...</div>
				<!--选择不同的发布方式-->
				<div id="publisher_type">
					<!--发布状态-->
					<div class="each_publisher_type current" id="status_upload_trigger">
						<span class="each_publisher_type_icon icon1"></span>
						<span class="each_publisher_type_name">状态</span>
					</div>
					<!--发布照片-->
					<div class="each_publisher_type">
						<span class="each_publisher_type_icon icon2"></span>
						<span class="each_publisher_type_name" id="pic_upload_trigger">照片</span>
						<form class="hideform" id="upload_pic_form" action="" method="POST" enctype="multipart/form-data">
							<input type="file" name="file" id="upload_pic"/>	
							<input type="text" class="hide" name="replaceCaption" id="replaceCaption"/>
						</form>	
					</div>
					<!--发布分享链接-->
					<div class="each_publisher_type">
						<span class="each_publisher_type_icon icon3"></span>
						<span class="each_publisher_type_name" id="share_upload_trigger">分享</span>
					</div>
				</div>
				
				<!--输入框-->
				<form action="" method = 'post'>
					<textarea name="text" id="publisher_input" cols="30" rows="10" maxlength="240"></textarea>
					<!--提交按钮-->
					<input type="submit" id="publisher_button" value="发布"/>
				</form>
				<div id="upload_pic_preview_box" class="upload_pic_preview_box hide">
					<input type="text" name="upload_pic_caption" id="upload_pic_caption" placeholder="照片描述"/>
					<div id="upload_pic_sendbutton" class="upload_pic_sendbutton">发布</div>
					<div id="upload_pic_cancelbutton" class="upload_pic_cancelbutton">取消</div>
				</div>
				<div id="upload_share" class="upload_pic_preview_box hide">
					<input type="text" name="shareUrl" id="shareUrl" placeholder="请输入分享链接"/>
					<textarea name="shareContent" id="shareContent" cols="30" rows="10" placeholder="请输入分享内容"></textarea>
					<div id="upload_share_sendbutton" class="upload_pic_sendbutton">发布</div>
					<div id="upload_share_cancelbutton" class="upload_pic_cancelbutton">取消</div>
				</div>
				<!--表情触发-->
				<div id="publisher_biaoqing"><span id="biaoqing_logo"></span>表情</div>
				
				
				<div id="biaoqing_float_box" title="hide">
					<div id="biaoqing_corner">♦</div>
					<ul>
						<li class="biaoqing_icon"><img src="img/biaoqing_icon.gif" alt="(谄笑)" /></li>
						<?php
							$bq =  $client->POST('status.getEmoticons','');
							foreach($bq as $item){
								echo '<li class="biaoqing_icon"><img src="'.$item['icon'].'" alt="'.$item['emotion'].'" /></li>';
							}
						?>
					</ul>
				</div>
			</div>
			<!--div#publisher发信息框-->
		</div>
		<script type="text/javascript" src="js/form.js"></script>
		<script type="text/javascript">
		$('#status_upload_trigger').click(function(){
			$('#upload_pic_preview_box').addClass('hide');
			$('#upload_share').addClass('hide');
		})
		//上传图片
			$('#pic_upload_trigger').click(function () {
				if(!$('#upload_share').hasClass('hide'))
				{
					$('#upload_share').addClass('hide');
				}
				$("#upload_pic_form").removeClass('hideform').addClass('showform');
			})
			
			$("#upload_pic").change(function () {
				$("#upload_pic_form").removeClass('showform').addClass('hideform');
				$('#upload_pic_preview_box').removeClass('hide');
			})
			
			$('#upload_pic_cancelbutton').click(function () {
				$('#upload_pic_preview_box').addClass('hide');
				$('#upload_pic_caption').attr('value','');
			})
			
			$('#upload_pic_sendbutton').click(function () {
				$('#replaceCaption').attr('value',$('#upload_pic_caption').attr('value'));
				$('#upload_pic_form').ajaxSubmit({
						  url: ajaxPhoto,
						  beforeSubmit:function () {
						  	 $('#uploading_status').removeClass('hide');
						  	 $('#upload_pic_preview_box').addClass('hide');
						  },
						  success: function(data) {
						  	 $('#news_box').prepend("<div class='picUploaded'><span>图片上传成功！</span><a href='"+data+"' target='_blank'><img src='"+data+"'/></a></div>");
						  	 $('#uploading_status').addClass('hide');
						  	 $('#upload_pic_caption').attr('value','');
					    }
				})
			})
			
			//分享内容
			$('#share_upload_trigger').click(function () {
				$('#upload_share').removeClass('hide');
			})
			
			$('#upload_share_cancelbutton').click(function () {
				$('#shareUrl').attr('value','');
				$('#shareContent').attr('value','');
				$('#upload_share').addClass('hide');
			})
			
			$('#upload_share_sendbutton').click(function () {
				var shareUrl = $('#shareUrl').val();
				var shareContent = $('#shareContent').val();
				var type;
				$.ajax({
					type:"POST",
					url:ajaxShare,
					data:{shareUrl:shareUrl,shareContent:shareContent,type:"url"},
					beforeSubmit:function () {},
					success:function (data) {
						$('#send_success_float_box').fadeIn(1200).fadeOut(3500);
						$('#shareContent').attr('value','');
						$('#upload_share').addClass('hide');
					}
				})
			})
		</script>