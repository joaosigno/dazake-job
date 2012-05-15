<?php
//登陆校验
require_once('./modular/checklogin.php');
//引入数据生成文件
require_once('modular/md_myhome.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/myhome.css" media="all" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<title></title>
</head>
<body>
	<!--div#container-->
	<div id="container">
		<!--div#header-->
		<?php include_once('./modular/header.php');?>
		<!--end div#header-->
		<!--div#main-->
		<div id="main">
			<!--div#news_box包裹所有新鲜事-->
			<div id="news_box">
			<?php
				foreach($zt as $item) {
			?>
				<!--div.each_news每一天新鲜事-->
				<div class="each_news">
					<div class="col-left">
						<!--当前用户照片-->
						<img src="<?php echo $us[0]['headurl'];?>" alt="" class="fds_portrait" />
					</div>
					
					<div class="col-mid">
						<div class="news_content">
							<!--当前用户姓名&新鲜事的题目-->
							<span class="news_title"><a href="" class="fds_name"><?php echo $us[0]['name'];?>	:</a><?php if(isset($item['prefix'])) echo $item['prefix'];?><?php if(isset($item['title'])) echo $item['title'];?></span>
							<!--新鲜事的文字部分-->
							<div class="text_content"><?php echo text_to_bq($item['message'],$bq);?></div>
							<!--来源-->
							<div class="source_name_content">来源:<?php echo $item['source_name'];?></div>
							 
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
			<a href = "?page=<?php echo $_GET['page']>1?$_GET['page']-1:1;?>"><span>上一页</span></a>
			<a href = "?page=<?php echo $_GET['page']+1;?>"><span>下一页</span></a>
			</div>
			<!-- end div#nav_page-->
		</div>
		<!--end div#footer-->
		
	</div>
	<!--end div#container-->
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>