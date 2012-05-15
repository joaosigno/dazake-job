<?php
	session_start();
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
	
	if(!empty($_POST['username']) && !empty($_POST['pwd']) ){

		$db = new DB();	
		$sql = "SELECT `id` ,`username` FROM  `".DAPRE."account` WHERE  `password` LIKE  '".md5(trim($_POST['pwd']))."'AND  `username` LIKE  '".$_POST['username']."'";
		$result = $db->get_one($sql);
		
		if($result){
			// 主用户登陆信息写入
			$_SESSION['login'] = true;
			$_SESSION['parentusername'] = $result['username'];
			
			
			//用户多账号信息写入
			$sql = "SELECT `id`, `name` FROM `".DAPRE."user` WHERE `parentusername` = '" . $_SESSION['parentusername'] ."'";
			$account = $db->get_all($sql);
			$_SESSION['account'] = $account;//多账户写入account
		
			header("Location: home.php");//初始化完毕。进入用户界面
		}else{
			$result = false;	
		}
	}
?>