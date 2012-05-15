<?php
	session_start();
	require_once '../class/requires.php';
	$client = new RenRenClient();
	$session_key = $_SESSION['key']['renren_token']['session_key'];
	$client->setSessionKey($session_key);
	
	print_r($session_key);
	
	// if(isset($_POST['addLike']))
	// print_r($us =  $client->POST('like.unlike',array('http://www.renren.com/g?ownerid=363524545&resourceid=5304799685&type=photo'))); 
	// print_r($us =  $client->POST('like.like',array('http://www.renren.com/g?ownerid=363524545&resourceid=535833712&type=photo'))); 
	// $us =  $client->POST('photos.addComment',array('363524545','(叹气)我要评论','5304799685'));
	// $us =  $client->POST('share.addComment',array('10309026246','363524545','(叹气)我要评论'));
	// $us =  $client->POST('share.addComment',array('10309026246','363524545','(叹气)我要评论'));
	// $us =  $client->POST('share.addComment',array('10309026246','363524545','(叹气)我要评论'));
	// $us =  $client->POST('share.addComment',array('10309026246','363524545','(叹气)我要评论'));
	// $us =  $client->POST('share.addComment',array('10309026246','363524545','(叹气)我要评论'));
	$us =  $client->POST('share.share',array('10','','','http://v.youku.com/v_playlist/f16666961o1p0.html','(叹气)我要分享'));
	// $us =  $client->POST('photos.upload',array('http://t1.baidu.com/it/u=3083345203,3534053739&fm=0&gp=0.jpg'));
	
	//分享 url  http://v.youku.com/v_playlist/f16666961o1p0.html
	
	print_r($us);
	
	
	
	
	// if(isset($_POST['removeLike']))
	// print_r($us =  $client->POST('like.unlike',array($_POST['removeLike']))); 
	
	
	// echo $_POST['addLike'].$_POST['removeLike'];



	
?>