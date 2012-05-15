<?php
session_start();
require_once("class/requires.php");
$login_url = qq_login_url($_SESSION["appid"], $_SESSION["scope"], $_SESSION["callback"]);

//自动跳转到授权

 header("Location: $login_url");

 
?>
<a href = "<?php echo $login_url ;?>">登陆</a>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QQ-LOGIN</title>
</head>
<body>
</body>