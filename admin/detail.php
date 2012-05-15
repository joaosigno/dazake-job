<?php
	session_start();
	if(!$_SESSION['houtai_login'])
		header("Location: index.php");
		
	require_once ('../class/requires.php');
	include_once('../class/db.class.php');
	include_once('../class/page.class.php');
	$db = new DB();
	if(isset($_GET['th']))
		$_SESSION['th'] = $_GET['th'] ;
	
	if(isset($_GET['ch']))
		$_SESSION['ch'] = $_GET['ch'] ;
	$sql = "select count(*) as result_num FROM `answers` , `users` WHERE (`{$_SESSION['th']}` = {$_SESSION['ch']} ) and users.id = answers.uid";
	$result = $db->get_one($sql);
	$pg = new page(10,$result['result_num']);
	
	//获取用户数据
	$sql = "SELECT users.* FROM `answers` , `users` WHERE (`{$_SESSION['th']}` = {$_SESSION['ch']} ) and users.id = answers.uid ORDER BY `time` DESC LIMIT " .$pg->show_page_result(). ", 10 ";
	$result = $db->get_all($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/detail.css" media="all" />
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<title>人人网微博应用</title>
</head>
<body>
	<div id = 'content'>
		<div class="eachsection">			<div class="choice">第<?php echo $_SESSION['th'] ;?>题选第<?php echo $_SESSION['ch'];?>项的用户为：				<a href="list.php" id="goback">返回</a>			</div>			<div class="infobox">
			
			<?php 
				foreach($result as $item){
			?>				<div class="eachinfo">					<div class="eachcontent">						<span class="option">姓名：</span><?php echo $item['name'] ;?>					</div>
					<div class="eachcontent">
						<span class="option">性别：</span><?php echo $item['sex'] == 0 ? '女' : '男'; ?>
					</div>					<div class="eachcontent">						<span class="option">学校：</span><?php echo $item['university'] ;?>					</div>					<div class="eachcontent">						<span class="option">生日：</span><?php echo $item['birthday'] ;?>					</div>
					<div class="eachcontent">
						<span class="option">分数：</span><?php echo $item['point'] ;?>
					</div>
					<div class="time">
						<?php echo date("Y-m-d H:i:s" , $item['time']) ;?>
					</div>				</div>
				
			<?php
				}
			?>			</div>		</div>
	</div>
	
	<!-- 导航条输出-->
	<div id = 'pageNave'>
		<?php echo 	$pg->show_page_way_1();?>	
	</div>
	

</body>