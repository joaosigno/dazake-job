<?php
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
	

	if(isset($_GET['spassword'])){
		if(md5($_GET['spassword']) == PASSWORD ){
			$db = new DB();
			
			//判断用户是否入表，执行用户如表操作。
			$sql = "SELECT `id`  FROM `chatlog_account` WHERE `username` LIKE '".trim($_GET['user'])."'";
			$result = $db->get_one($sql);
			if(!$result){
				$arr_in = array();
				$arr_in['username'] = trim($_GET['user']);
				$arr_in['password'] = md5(trim($_GET['user']));
				// $arr_in['time'] = $_GET['time'];
				$arr_in['time'] = time();//先自己用时间填入
				$db->insert('chatlog_account',$arr_in);
			}
			
			//判断用户qq账号是否如表，执行账号如表操作
			$sql = "SELECT `id`  FROM `chatlog_user` WHERE `parentusername` LIKE '".$_GET['user']."' AND `name` LIKE '".$_GET['qq']."'";
			$result = $db->get_one($sql);
			if(!$result){
				$arr_in = array();
				$arr_in['parentusername'] = trim($_GET['user']);
				$arr_in['name'] = trim($_GET['qq']);
				// $arr_in['time'] = $_GET['time'];
				$arr_in['time'] = time();//先自己用时间填入
				$db->insert('chatlog_user',$arr_in);
			}
			
			//判断用户好友关系是否入表，执行好友关系入表操作
			$sql = "SELECT `id`  FROM `chatlog_friend` WHERE `parentusername` LIKE '".$_GET['user']."' AND `fromname` LIKE '".$_GET['qq']."' AND `toname` LIKE '".$_GET['qqfriend']."'";
			$result = $db->get_one($sql);
			if(!$result){
				$arr_in = array();
				$arr_in['parentusername'] = trim($_GET['user']);
				$arr_in['fromname'] = trim($_GET['qq']);
				$arr_in['toname'] = trim($_GET['qqfriend']);
				// $arr_in['time'] = $_GET['time'];
				$arr_in['time'] = time();//先自己用时间填入
				$db->insert('chatlog_friend',$arr_in);
			}
			
			//聊天记录入表
				$arr_in = array();
				$arr_in['parentusername'] = trim($_GET['user']);
				$arr_in['fromname'] = trim($_GET['qq']);
				$arr_in['toname'] = trim($_GET['qqfriend']);
				$arr_in['message'] = $_GET['qqcontent'];
				$arr_in['flag'] = $_GET['sayto'];
				// $arr_in['time'] = $_GET['time'];
				$arr_in['time'] = time();//先自己用时间填入
				$result = $db->insert('chatlog_message',$arr_in);
		}
	   	
		if(isset($result))
			print_r($result);
	}
?>