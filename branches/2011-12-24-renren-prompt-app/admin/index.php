<?php
	session_start();
	require_once ('../class/requires.php');
	if(isset($_POST['passwd'])){
		if( trim($_POST['userName']) == USERNAME && md5(trim($_POST['passwd'])) == PASSWORD){
			$_SESSION['houtai_login'] = true;
			header("Location: list.php");

		}
	
	}
?>
<!DOCTYPE HTML><html lang="en-US"><head>	<meta charset="UTF-8">	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />	<title>后台登陆</title></head><body>	<form action = '' method = 'POST' id="backstageForm"> 		<label for="userName">User:</label>		<input type="text" name="userName" id="userName" class="inputarea" value=""/><br />		<label for="passwd">Password:</label>
		<input type="password" name="passwd" class="inputarea" value=""/>		<input type="submit" value="登陆" id="sendButton"/>
	</form></body></html>
