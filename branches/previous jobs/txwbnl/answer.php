<?php
	$con_arr = array();	
	$con_arr[55] = '「眼波传情型」55% 感情丰富的你会有意无意地透过眼神放电，不自觉地让别人暗恋你。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com 分享自@翻到就行';
	$con_arr[20] = '「反应白目型」20% 你活在自己世界中，反应永远慢半拍，就算别人对你示好，你反而还感应不到。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com 分享自@翻到就行';
	$con_arr[99] = '「狮子示爱型」99% 你会不自觉地经由身体的接触，让别人觉得你对他有意思，相对地也使别人对你献殷勤的机会大增。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com 分享自@翻到就行';
	$con_arr[40] = '「无聊解闷型」40% 当生活乏味无聊时，你会偶尔放放电，让人家觉得平常不太出色的你还满吸引人的。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com 分享自@翻到就行';
	$con_arr[80] = '「对话传情型」80% 感性的你容易在言语中向别人挑逗暗示，让人觉得你好像在告诉对方可以接近。[呵呵]还真是。看看#你被人暗恋的指数有多高#http:www.baidu.com分享自@翻到就行';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/common.css" media="all" />
	<title>你被暗恋的指数</title>
</head>
<body>
	<div id="container1" class="container" style="background: url('upload/b<?php echo $_POST['q0'] ; ?>.jpg');">
			<div id="main">
					<form action="last.php" method = "POST">
							<textarea name="main" id="inputzone" cols="30" rows="10" value=""><?php echo $con_arr[$_POST['q0']] ; ?></textarea>
							<div id="selectbox">
								<input type="checkbox" name = "cb_guanzhu" id="check"/><span id="guanzhu">关注翻到官方微博......</span>
								<input type="hidden" name = "q0" value = "<?php echo $_POST['q0'] ; ?>" />
							</div>
							<div id="alertbox" class="hide">
								<span id="alert">是否关注我们的官方微博以便及时知道最新应用动态？</span>
								<input type="submit"  name = "send_weibo_y"  id="" value="确定"/>
								<input type="submit"  name = "send_weibo_n"  id="" value="取消"/>
							</div>
							<input type="button" value="" src="img/button.png" name="fakeSend" id="send" />
							<span id="share">点击提交按钮分享到新浪微博</span>
						</form>
						<a href="home.php" id="again">再测一遍</a>
				</div>
	</div>
	<div id="footer">
		<img src="img/logo.jpg" alt="" id="logo" />
		<a href="logout.php">取消授权</a>
		<a target = "_blank" href="friendadd.php">联系开发者</a>
		<span>开发者信息</span>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript">
		$(function () {
			$("#send").click(function () {
				$("#alertbox").removeClass("hide");
			})
		})
	</script>
</body>
</html>