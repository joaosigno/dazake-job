<?php
	session_start();
	require_once '../class/requires.php';
	$client = new RenRenClient();
	$session_key = $_SESSION['key']['renren_token']['session_key'];
	$client->setSessionKey($session_key);

	
//评论	
	switch ($_POST['type']){
		case 'statu':
  			print_r($client->POST('status.addComment',array($_POST['ownerId'],$_POST['srcId'],$_POST['comment'])));
  			break;  
		case 'share':
			print_r($client->POST('share.addComment',array($_POST['ownerId'],$_POST['srcId'],$_POST['comment'])));
  			break;
		case 'album':
			print_r($client->POST('photos.addComment',array($_POST['ownerId'],$_POST['srcId'],'',$_POST['comment'])));
  			break; 	
		case 'photo':
			print_r($client->POST('photos.addComment',array($_POST['ownerId'],'',$_POST['srcId'],$_POST['comment'])));
  			break;
		case 'blog':
			print_r($client->POST('blog.addComment',array($_POST['ownerId'],$_POST['srcId'],$_POST['comment'])));
  			break; 			
		default:
 			echo 'ERROR';
	}
?>