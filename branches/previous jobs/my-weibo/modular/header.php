<?php

	//如果是发送微博，数据入库
	if(isset($result['request'])&&$result['request']=='text'){
		$sql_arr = array();
		$sql_arr['w_id'] = $_SESSION['id'];
		$sql_arr['addTime'] = time();
		$sql_arr['messages'] = $result['text'];
		$sql_arr['name'] = $result['user']['name'];
		if(isset($result['thumbnail_pic'])){
			$sql_arr['thum_pic'] = $result['thumbnail_pic'];	
		}
		if(isset($result['original_pic'])){
			$sql_arr['src_pic'] = $result['original_pic'];
		}
		$db->insert(DB_TABLE_PREFIX.'sina_message',$sql_arr);
	}
?>

<body>
	<!--//最外层框框 宽度：315px;-->
	<div id="container" class="box-shadow">
	
		<!--顶栏，包括新浪微博Logo,用户名，和退出-->
		<div id="topbar">
			<!--sina logo-->
			<a href="<?php dirname(__FILE__)?>weibolist.php" id="sina_logo"></a>
			
			<!--用户名-->
			<label for="portrait"><a href="<?php dirname(__FILE__)?>weibolist.php" id="userid" class="userid"><?php echo $user_message['screen_name'];?></a></label>
			
			<!--退出-->
			<a href="<?php dirname(__FILE__)?>modular/logout.php">退出</a>
		</div>
		<!--end div#topbar-->
		
		<!--头部，包括用户头像，关注数，粉丝数，微博数，发布框，表情，图片，视频-->
		<div id="header">
		
			<!--第一栏，包括用户头像，关注数，粉丝数，微博数-->
			<div id="col1" class="col">
				<!--左边栏：用户头像-->
				<div id="col1-left">
					<a href="<?php dirname(__FILE__)?>weibolist.php" name="portrait"><img src="<?php echo $user_message['profile_image_url'];?>" alt="" id="portrait" /></a>
				</div>
				
				<!--右边栏-->
				<div id="col1-right">
					<!--关注数-->
					<div class="func">
						<span><?php echo $user_message['friends_count'];?></span><br/>
						<a href="<?php dirname(__FILE__)?>guanzhu.php" >关注</a>
					</div>
					
					<!--粉丝数-->
					<div class="func">
						<span><?php echo $user_message['followers_count'];?></span><br/>
						<a href="<?php dirname(__FILE__)?>fensi.php" >粉丝</a>
					</div>
					
					<!--微博数-->
					<div class="func">
						<span><?php echo $user_message['statuses_count'];?></span><br />
						<a href="<?php dirname(__FILE__)?>myweibo.php" >微博</a>
					</div>
					
					<!--收藏数-->
					<div class="func">
						<span><?php echo $user_message['favourites_count'];?></span><br />
						<a href="<?php dirname(__FILE__)?>shoucang.php" >收藏</a>
					</div>
					
				</div>
			</div>
			<!--end div#col2-->
			
			
			<!--第二栏：包括发布框，表情，图片，视频-->
			<div id="col2" class="col">
					<!--有什么新鲜事想告诉大家Logo-->
					<span id="slogan"></span>
					<!--********11-19修改**********-->
					<span id="input_count">你还可以输入<span id="input_left_number">140</span>字</span>
					<!--********11-19修改**********-->
					
					<!--发布框表单-->
					<form action="" method = "post">
						
						<!--********11-19修改**********-->
						<!--微博内容输入框-->
						<textarea id="input_text" name="text" maxlength="140" cols="30" rows="10" onkeyup="countLeft(this.value)"></textarea>
						<!--********11-19修改**********-->
						
						<!--图片链接输入框-->	
						<input type="text" class="hide" id="input_pic" name = "pic" />
						
						<!--视频地址输入框-->
						<input type="text" id="input_video" name = "video" style="display:none"/>
						
						<!--发送按钮-->
						<input type="submit" id="send_button" value=""  class="box-shadow"/>
					</form>
					
					
					<!--表情，图片，视频部分
						分三部分，每一部分都有共同属性：
						class="upload_box"
						图片：class="upload_func_logo"
						文字：class="float_trigger"
						弹出框：class="float_box"
						
						针对图片和视频公共部分：
						弹出框里的链接输入框:
						class="float_input_text"
						上传按钮：class="float_send"
						取消按钮：class="float_cancel"
					-->
					<div id="upload_box">
						
						<!--弹出成功上传信息-->
						<div id="float_msn" style="display: none;"></div>
						
						<!--表情部分-->
						<div class="upload_func" id="upload_biaoqing">
							<span class="upload_func_logo"></span>
							<span id="biaoqing" class="float_trigger">表情</span>
							<!--********11-19修改**********-->
							<div class="float_box float_box_biaoqing" style="display: none;">
								<ul>
									<?php
									for($i=0;$i<64;$i++){
									echo '<li class="biaoqing_img"><img src="'.$bq[$i]['icon'].'" alt="'.$bq[$i]['phrase'].'" /></li>';
									}
									?>
								</ul>
								<!--取消按钮-->
								<div class="float_cancel">取消</div>
							</div>
							<!--********11-19修改**********-->
						</div>
						
						
						
						<!--图片部分-->
						<div class="upload_func" id="upload_pic">
							<span class="upload_func_logo"></span>
							<span id="pic" class="float_trigger">图片</span>
							
							<!--弹出框-->
							<div class="float_box" style="display:none">
							
								<!--链接输入框-->
								<!--<input type="text" class="float_input_text" placeholder="请输入图片链接"/>-->
								
								<!--上传按钮-->
								<img src="" alt="" id="upload_pic_preview" class="hide"/>
								<form id="uploadForm" action="modular/upload.php" method="POST" enctype="multipart/form-data">
									<input type="file" name="file" id="choose_file" />
								</form>
								<div id="clear_form" class="hide">x</div>
								<div id="upload_tip" style="display: none;">.</div>
								<!--取消按钮-->
								<div class="float_cancel">取消</div>
							</div>
							<!--end div.float_box-->
						</div>
						<!--end div#upload_pic-->
						
						<!--视频部分-->
						<div class="upload_func" id="upload_video">
							<span class="upload_func_logo"></span>
							<span id="video" class="float_trigger">视频</span>
							
							<!--弹出框-->
							<div class="float_box" style="display:none">
							
								<!--链接输入框-->
								<input type="text" class="float_input_text" placeholder="请输入视频链接"/>
								
								<!--上传按钮-->
								<div class="float_send" name="input_video">上传</div>
								
								<!--取消按钮-->
								<div class="float_cancel">取消</div>
							</div>
							<!--end div.float_box-->
							
						</div>
						<!--end div#upload_video-->
					</div>
					<!--end div#upload_box-->
			</div>
			<!--end div#col2-->
		</div>
		<!--end div#header-->
		<script type="text/javascript" src="js/form.js"></script>
		<script type="text/javascript">
		
			$(function () { 
				$('#clear_form').click(function () {
//					var file = $(":file");  
//					file.after(file.clone().val(""));  
//					file.remove();
					$(this).addClass('hide');
					$('#upload_pic_preview').addClass('hide'); 
				})
				
				$('#choose_file').change(function () {
					$('#uploadForm').ajaxSubmit({
							  beforeSubmit:function () {
							  	$('#upload_tip').show();
							  },
							  success: function(data) { 
							  	 var imgUrl = data;
							  	 $('#input_pic').attr('value',imgUrl);
							  	 $('#upload_pic_preview').attr('src',imgUrl).removeClass('hide');
								 $('#upload_tip').hide();
								 $('#clear_form').removeClass('hide');
						    }
					})
				})
				
				$('.float_confirm').click(function () {
					$(this).parent('.float_box').hide();
				})
			})
		</script>