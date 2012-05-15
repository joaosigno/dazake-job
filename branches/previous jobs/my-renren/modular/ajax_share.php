<?php
	session_start();
	require_once '../class/requires.php';
	$client = new RenRenClient();
	$session_key = $_SESSION['key']['renren_token']['session_key'];
	$client->setSessionKey($session_key);
	//转换url type
	
	if(isset($_POST['type'])&&$_POST['type']=='url'){
		$_POST['commentShareType'] = $_POST['type'];
	}
	
	//分享
	// 日志为1、照片为2、链接为6、相册为8、视频为10、音频为11、分享为20。
		switch ($_POST['commentShareType']){
			case 'share':
				print_r($client->POST('share.share',array(20,$_POST['commentShareOwnId'],$_POST['commentShareSrcId'],$_POST['ommentShareContent'],'')));
  				break;
			case 'album':
				print_r($client->POST('share.share',array(8,$_POST['commentShareOwnId'],$_POST['commentShareSrcId'],$_POST['commentShareContent'],'')));
  				break; 	
			case 'photo':
				print_r($client->POST('share.share',array(2,$_POST['commentShareOwnId'],$_POST['commentShareSrcId'],$_POST['commentShareContent'],'')));
  				break;
			case 'blog':
				print_r($client->POST('share.share',array(1,$_POST['commentShareOwnId'],$_POST['commentShareSrcId'],$_POST['commentShareContent'],'')));
  				break;
			case 'url':
				print_r($result = $client->POST('share.share',array(6,'','',$_POST['shareContent'],$_POST['shareUrl'])));
				include_once('../class/db.class.php');
				$db = new DB();
				$sql_arr = array();
				$sql_arr['w_id'] = $_SESSION['id'];
				$sql_arr['type'] = 'share';
				$sql_arr['prefix'] = $result['title'];	
				$sql_arr['url'] = $_POST['shareUrl'];		
				$sql_arr['messages'] = $_POST['shareContent'];		
				$sql_arr['img'] = $result['thumbnail_url'];		
				$sql_arr['addTime'] = time();			
				$db->insert(DB_TABLE_PREFIX.'renren_message',$sql_arr);
  				break; 			
			default:
 				echo 'ERROR';
		}
?>