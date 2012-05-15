<?php
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
	if(isset($_POST['password'])){
		
		if(md5($_POST['password']) == PASSWORD ){
		$db = new DB();
		
		$arr_data = array();
		$arr_data['fromuid'] = $_POST['fromuid'];
		$arr_data['touid'] = $_POST['touid'];
		$arr_data['message'] = $_POST['message'];
		$arr_data['time'] = time();
		
		print_r($db->insert('message',$arr_data));
		
		}
	}

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
	<title>Login</title>
</head>
<body>

	<article id="main">
		<div id = "account">
			<form action="" method = "POST" id="loginForm">
			留言发起者id：<input id="fromuid" name = "fromuid" type="text" />
			留言接受者id：<input id="touid" name = "touid" type="text" />
			留言内容：<input id="message" name = "message" type="text" />
			插入密码：<input id="password" name = "password" type="password" />
			<input id="button" type="submit" value="提交"/>
			</form>
		</div>
	
	
		<form action="" method = "POST" id="loginForm">
			留言发起者id：<input id="fromuid" name = "fromuid" type="text" />
			留言接受者id：<input id="touid" name = "touid" type="text" />
			留言内容：<input id="message" name = "message" type="text" />
			插入密码：<input id="password" name = "password" type="password" />
			<input id="button" type="submit" value="提交"/>
		</form>
	</article>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>