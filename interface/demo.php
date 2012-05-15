<?php
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'interface.php');


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
	<title>Interface Demo</title>
</head>
<body>

	<article id="main">
		<div id = "indexPage">
			<a href ="http://localhost/xampp/2012-1-10-chatlog/interface/demo.php">首页</a>
		</div
		
		<div id = "interface">
			<form action="" method = "GET" id="loginForm">
			<span>接口测试实例</span>
			用户账号"user"<input id="user" name = "user" type="text" />
			用户qq号"qq"<input id="qq" name = "qq" type="text" />
			用户朋友qq号"qqfriend"<input id="qqfriend" name = "qqfriend" type="text" />
			聊天内容"qqcontent"<input id="qqcontent" name = "qqcontent" type="text" />
			聊天内容加入时间"time"<input id="time" name = "time" type="text" />
			聊天内容标记"sayto"<input id="sayto" name = "sayto" type="text" />
			安全密码"spassword"<input id="spassword" name = "spassword" type="password" />
			<input id="button" type="submit" value="增加聊天记录接口"/>
			</form>
		</div>
	</article>
</body>
</html>