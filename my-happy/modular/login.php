<?php
/**
*用户账号密码与数据库匹配
*写入session
*重定向到用户首页
*
*
*/
?>
<?php
	session_start();
	if(isset($_POST['submit'])){
		require_once ('../class/requires.php');
		$md5_pass = md5(trim($_POST['password'])); //md5加密password
		$_POST['name'] = trim($_POST['name']);
		$db = new DB();
		$sql = "SELECT * FROM ".DB_TABLE_PREFIX."user WHERE name LIKE '{$_POST['name']}' AND password LIKE '{$md5_pass}'";
		$result = $db->get_one($sql);	
		//登陆控制判断
		if($result){
			$_SESSION['id']=$result['id'];
			$_SESSION['name']=$result['name'];
			header("Location: ../index.php");
		}else{
			echo '登陆失败';
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<!--********11-19修改**********-->
	<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
	<!--********11-19修改**********-->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<title>新浪微博-by Micheal</title>	
</head>
<body>
<form action="" method = "POST">
<input type="text" name = "name" />
<input type="password" name = "password" />
<input type="submit" name = "submit" value = "登陆" />
</form>
</body>
