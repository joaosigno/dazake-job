<?php
	session_start();
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
	
	if(!empty($_POST['username']) && !empty($_POST['pwd']) ){

		$db = new DB();	
		$sql = "SELECT `id` ,`username` FROM  `".DAPRE."account` WHERE  `password` LIKE  '".md5(trim($_POST['pwd']))."'AND  `username` LIKE  '".$_POST['username']."'";
		$result = $db->get_one($sql);
		
		if($result){
			// ���û���½��Ϣд��
			$_SESSION['login'] = true;
			$_SESSION['parentusername'] = $result['username'];
			
			
			//�û����˺���Ϣд��
			$sql = "SELECT `id`, `name` FROM `".DAPRE."user` WHERE `parentusername` = '" . $_SESSION['parentusername'] ."'";
			$account = $db->get_all($sql);
			$_SESSION['account'] = $account;//���˻�д��account
		
			header("Location: home.php");//��ʼ����ϡ������û�����
		}else{
			$result = false;	
		}
	}
?>