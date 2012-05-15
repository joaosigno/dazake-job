<?php
	require_once('modular/mlogin.php');
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
	<title>Login</title>
</head>
<body>
	<div id="main">
		<?php
		// 等登陆错误时候才输出
		if(isset($result)){
			if(!$result)
				echo "<script type='text/javascript'>alert('输入错误，请重新输入');</script>";
		}
		?>
		
		<form action="" method = "POST" id="loginForm">
			<input id="email" name = "username" type="text" />
			<input id="pwd" name = "pwd" type="password" />
			<input id="button" type="submit" value=""/>
		</form>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>

