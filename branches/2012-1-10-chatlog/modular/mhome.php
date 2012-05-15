<?php
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
		
		// 修改用户id
		// if(isset($_POST['userName']))
			// $_SESSION['id'] = $_POST['userName'];
		// print_r($_POST['type']);
		
		// $id = $_SESSION['id'];
		
		
		// $db = new DB();	
		
		// 获取总聊天记录数
		// $sql = "select count(*) as result_num FROM `message`  WHERE (`fromuid` = 1 AND `touid` = 2 ) OR (`fromuid` = 2 AND `touid` = 1 ) ";
		// $result = $db->get_one($sql);
		// $pg = new page(10,$result['result_num']);
		
		//获取用户好友列表
		// $sql = "select user.name , user.id from user where user.id in ( SELECT `touid` FROM `friend` WHERE `fromuid` = ".$_SESSION['id'].") ";
		// $friends = $db->get_all($sql);
		// print_r($friends);
		
		//获取好友姓名
		// $sql = "SELECT `name` FROM `user` WHERE `id` = 2 LIMIT 0, 30 ";
		// $friendname = $db->get_one($sql);
		// $_SESSION['friendname'] = $friendname['name'];
		
		// 获取用户与好友聊天记录
		// $sql = "SELECT * FROM `message` WHERE (`fromuid` = 1 AND `touid` = 2 ) OR (`fromuid` = 2 AND `touid` = 1 ) ORDER BY `time` DESC LIMIT 0, 30 ";
		// $message = $db->get_all($sql);
		
		
		// echo 	$pg->show_page_way_1();
		
		
		
	
?>