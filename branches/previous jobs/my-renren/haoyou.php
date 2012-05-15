<?php
//登陆校验
require_once('./modular/checklogin.php');
//引入数据生成文件
require_once('modular/md_haoyou.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/haoyou.css" media="all" />
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
			<div id="contactbox">
				<?php
				foreach($friends as $item) {
					$statu = $client->POST('status.gets',array($item['id'],'1','1'));
					echo '<div class="each_contact">';
					echo '<div class="contact_img"><a target = "_blank" href = "http://www.renren.com/profile.do?id='.$item['id'].'"><img src="'.$item['headurl'].'" alt="" /></a></div>';
					echo '<div class="contact_name"><a href="">'.$item['name'].'</a></div>';
					if(isset($statu[0]['message']))
						echo '<div class="contact_statu"><a href="">'.text_to_bq($statu[0]['message'],$bq).'</a></div>';
					if(isset($statu[0]['source_name']))
						echo '<div class="contact_source_name">来源：'.$statu[0]['source_name'].'</div>';
					echo '</div>';
				}
				?>
			</div>
		</div>
		<!--end div#main-->
		<!-- div#nav_page--分页导航-->
		<div id = "nav_page">
		<a href = "?page=<?php echo $_GET['page']>1?$_GET['page']-1:1;?>"><span>上一页</span></a>
		<a href = "?page=<?php echo $_GET['page']+1;?>"><span>下一页</span></a>
		</div>
		<!-- end div#nav_page-->
		
	</div>
	<!--end div#container-->
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		$('.each_contact').mouseover(function () {
			$(this).children('.contact_cancel_button').show();
		})
		
		$('.each_contact').mouseout(function () {
			$(this).children('.contact_cancel_button').hide();
		})
	</script>
</body>
</html>