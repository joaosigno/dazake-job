<?php
	session_start();
	require_once("class/requires.php");
	
	function get_user_info()
	{
		$get_user_info = "https://graph.qq.com/user/get_user_info?"
  	    . "access_token=" . $_SESSION['access_token']
       . "&oauth_consumer_key=" . $_SESSION["appid"]
       . "&openid=" . $_SESSION["openid"]
       . "&format=json";

   $info = get_url_contents($get_user_info);
   $arr = json_decode($info, true);

   return $arr;
	}
	
	$uinfo = get_user_info();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/fancybox.css" media="all" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/fancybox.js"></script>
<script type="text/javascript" src="js/md5.min.js"></script>
</head>
<body>
<script type="text/javascript">
	$(document).ready(function(){
		$("#forgetPass").fancybox({
			'width'				: 340,
			'height'			: 300,//269,
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});	
	})
</script>
<!-- <li><a id="various3" href="http://google.ca">Iframe</a></li> -->
<div id="header"><a href="http://www.wanfuwang.com" id="title">万服网</a></div>
<div id="main">
	<div id="leftbox">
		<h3>欢迎来到</h3>
		<div id="left_info">
			<img src="images/logo.png" alt="" id="logo" />
			<img src="images/info.gif" alt="" id="info" />
		</div>
	</div>	
	<div id="nav"></div>
	<div id="rightbox">
		<h3>绑定QQ账号到万服网</h3>
		<form action="add.php" method="post"  name="registerform" id="registerform" onSubmit="" class="rf">
			<ul>
				<li>
					<label for="nick" id="name">您好:<?php echo $uinfo['nickname']; ?></label>
				</li>
				
				<img src="<?php echo $uinfo['figureurl_1'] ;?>" alt="" id="portrait" />
<!--				<li id="tips" style="text-indent: 20px;">请输入您的邮箱地址和密码:</li>-->
				<li>
				<span class="pre">邮箱:</span>
				<input type="text" name="email" value="" id="email" style="margin-left: 52px;"/><span id="alertno" style="display: none;color: #C33814;font-size: 12px;">该邮箱已经被注册</span><span id="alertyes" style="display: none;color: green;font-size: 12px;">该邮箱可以使用</span><span id="alertmailno" style="display: none;color: #C33814;font-size: 12px;">邮箱格式错误!</span><br />
				</li>
				<li style="text-align:center;"><img class="hide" src="images/loading.gif" alt="" id="loading" /></li>
				<div id="hideform" class="hide">
				<li>
				<span class="pre">万服网密码:</span>
				<input type="password" name="password" value="" id="password"/><br />
				</li>
				<li>
				<span class="pre">重复密码:</span>
				<input type="password" name="repassword" value="" id="repassword" style="margin-left: 22px;"/><span id="alertpass" style="display: none;color: #C33814;font-size: 12px;">两次输入的密码不一样</span><span style="color: green;display: none;" id="passok">OK</span><br />
				</li>
				</div>
				<div id="alreadybox" class="hide">
					<li>
						<div id="alreadyalert" style="text-indent:20px;color:red;font-size:13px;">账号已经存在,请输入密码登陆 <a id="forgetPass" href="http://www.wanfuwang.com/forgot_password.php">忘记密码?</a></div>
						<span class="pre">万服网密码:</span>
						<input type="password" name="password" value="" id="password" class="password2"/><br />
					</li>
				</div>
				<input type="button" value="提交" id="submit" /><span id="alert" style="display: none;color: #C33814;font-size: 12px;"> * 请输入正确的邮箱地址和密码</span>
				<input type="submit" name="msubmit" id="button"  style="display: none;"/>
				
				<br />
			</ul>
		</form>
	</div>
</div>
	<script type="text/javascript" src="js/validate.js"></script>
</body>
</html>