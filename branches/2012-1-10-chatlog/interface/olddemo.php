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
		
		<div id = "account">
			<form action="" method = "GET" id="loginForm">
			登陆用户名：<input id="username" name = "username" type="text" />
			登陆密码：<input id="password" name = "password" type="password" />
			安全密码：<input id="spassword" name = "spassword" type="password" />
			<input id="type" name = "type" value = "account" type="hidden" />
			<input id="button" type="submit" value="增加用户提交"/>
			</form>
		</div>
		
		<div id = "user">
			<form action="" method = "GET" id="loginForm">
			账号名字：<input id="username" name = "username" type="text" />
			账号所属用户id注意填写的是id号：<input id="parentid" name = "parentid" type="text" />
			账号邮箱：<input id="email" name = "email" type="text" />
			安全密码：<input id="spassword" name = "spassword" type="password" />
			<input id="type" name = "type" value = "user" type="hidden" />
			<input id="button" type="submit" value="增加用户账号提交"/>
			</form>
		</div>
		
		<div id = "friend">
			<form action="" method = "GET" id="loginForm">
			成为好友其中一个账号id注意是id号码：<input id="fromuid" name = "fromuid" type="text" />
			成为好友另外一个账号id注意是id号码：<input id="touid" name = "touid" type="text" />
			安全密码：<input id="spassword" name = "spassword" type="password" />
			<input id="type" name = "type" value = "friend" type="hidden" />
			<input id="button" type="submit" value="增加好友关系提交"/>
			</form>
		</div>
		
		<div id = "message">
			<form action="" method = "GET" id="loginForm">
			记录内容发起者id注意是id号码：<input id="fromuid" name = "fromuid" type="text" />
			记录内容接受者id注意是id号码：<input id="touid" name = "touid" type="text" />
			记录内容信息：<input id="message" name = "message" type="text" />
			安全密码：<input id="spassword" name = "spassword" type="password" />
			<input id="type" name = "type" value = "message" type="hidden" />
			<input id="button" type="submit" value="增加记录内容信息"/>
			</form>
		</div>
	</article>
</body>
</html>