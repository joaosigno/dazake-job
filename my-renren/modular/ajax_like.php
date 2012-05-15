<?php
	session_start();
	require_once '../class/requires.php';
	$client = new RenRenClient();
	$session_key = $_SESSION['key']['renren_token']['session_key'];
	$client->setSessionKey($session_key);

	if(!$_POST['isLike']){	
	//还没有喜欢，做喜欢操作
		switch ($_POST['type']){
			case 'statu':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.like',array($url)));
	  			break;  
			case 'share':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.like',array($url)));
	  			break;
			case 'album':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.like',array($url)));
	  			break;
			case 'photo':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.like',array($url)));
	  			break;			
			case 'blog':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.like',array($url)));
	  			break; 			
			default:
	 			echo 'default';
		}
	}else{
	//已经喜欢，取消喜欢操作
		switch ($_POST['type']){
			case 'statu':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.unlike',array($url)));
	  			break;  
			case 'share':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.unlike',array($url)));
	  			break;
			case 'album':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.unlike',array($url)));
	  			break;
			case 'photo':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.unlike',array($url)));
	  			break;			
			case 'blog':
				$url = "http://www.renren.com/g?ownerid={$_POST['ownerId']}&resourceid={$_POST['srcId']}&type={$_POST['type']}";
	  			print_r($client->POST('like.unlike',array($url)));
	  			break; 			
			default:
	 			echo 'default';
		}
	}
?>