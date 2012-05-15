<?php
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
	$db = new DB();

	if(isset($_GET['spassword'])){	
		if(md5($_GET['spassword']) == PASSWORD ){
			switch($_GET['type']){
				case 'account'://账号插入
					// print_r($_GET);
					$arr_data = array();
					$arr_data['username'] = trim($_GET['username']);
					$arr_data['password'] = md5(trim($_GET['password']));
					$arr_data['time'] = time();
					$result = $db->insert($_GET['type'],$arr_data);
					break;
				case 'user':
					// print_r($_GET);
					$arr_data = array();
					$arr_data['name'] = trim($_GET['username']);
					$arr_data['parentid'] = trim($_GET['parentid']);
					$arr_data['email'] = trim($_GET['email']);
					$arr_data['time'] = time();
					$result = $db->insert($_GET['type'],$arr_data);
					break;
				case 'friend':
					// print_r($_GET);
					$arr_data = array();
					$arr_data['fromuid'] = trim($_GET['fromuid']);
					$arr_data['touid'] = trim($_GET['touid']);
					$arr_data['time'] = time();
					$result = $db->insert($_GET['type'],$arr_data);
					
					// 两个人成为好友所以要插入两次
					$arr_data = array();
					$arr_data['touid'] = trim($_GET['fromuid']);
					$arr_data['fromuid'] = trim($_GET['touid']);
					$arr_data['time'] = time();
					$db->insert($_GET['type'],$arr_data);
					break;
				case 'message':
					// print_r($_GET);
					$arr_data = array();
					$arr_data['fromuid'] = trim($_GET['fromuid']);
					$arr_data['touid'] = trim($_GET['touid']);
					$arr_data['message'] = trim($_GET['message']);
					$arr_data['time'] = time();
					$result = $db->insert($_GET['type'],$arr_data);
					break;
				default:
					return ;
			}
		}
	   	
		if(isset($result))
			print_r($result);
	}
?>