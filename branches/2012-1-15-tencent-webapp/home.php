<?php
	session_start();
	error_reporting('0');
    //设置include_path 到 OpenSDK目录
	set_include_path(dirname(__FILE__) . '/class/');
	require_once 'OpenSDK/Tencent/Weibo.php';

	include 'class/appkey.php';
	include 'class/config.php';

	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

    //打开session
    header('Content-Type: text/html; charset=utf-8');
    if(isset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]) && isset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET])){
	$uinfo = OpenSDK_Tencent_Weibo::call('user/info');//获取用户信息
	$friendinfo = OpenSDK_Tencent_Weibo::call('friends/idollist',array('reqnum' => '24'));//获取用户信息
	
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>2012年，你的幸运日是哪一天？</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="header">
	<div class="c">
	
	</div>
</div><div class="main clearfix">
	<div class="left">
		<div class="title">			<div class="l"><div style="padding-left:40px;"><img src="images/logo.jpg" /></div></div>			<div class="r"><span>人气<span><div class="n" id="usenum">124,018</div></div>
		</div>
		<div class="me">
			<div class="l"><img src="<?php if( !empty($uinfo['data']['head'])){echo $uinfo['data']['head'].'/100';}else{echo WEBSIZE .'qq100.jpg';} ?>" /></div>
			<dl>
				<dt><?php echo $uinfo['data']['nick'] ;?></dt>
				<dd class="v">
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
					<img src="http://good.ci123.com/app2/styles/gn/images/view2.gif" width="134" height="32" alt="查看结果，并发送微博" title="查看结果，并发送微博" onclick="pubPost('<?php echo $uinfo['data']['name'] ;?>','<?php echo $uinfo['data']['nick'] ?>','<?php if( !empty($uinfo['data']['head'])){echo $uinfo['data']['head'].'/50';}else{echo WEBSIZE .'qq50.jpg';} ?>');" />
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				</dd>
				
				<dd class="gz"><input type="checkbox" name="friend" id="gz" onclick="followMe(this.checked);" />
				<label for="gz">关注我们的微博</label>
				</dd>
			</dl>
		</div><!--/me-->
		<div class="friends">
			<div class="t">查看好友：</div>
			<ul class="clearfix">
			
			<?php foreach($friendinfo['data']['info'] as $item){ ?>
				<li onmouseover="this.className='on';" onmouseout="this.className='';">
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
					<img src="<?php if( !empty($item['head'])){echo $item['head'].'/50';}else{echo WEBSIZE .'qq100.jpg';} ?>" title="查看结果，并发送微博" width="50" height="50"  onclick="pubPost('<?php  echo $item['name'] ;?>','<?php  echo $item['nick'] ;?>','<?php if( !empty($item['head'])){echo $item['head'].'/50';}else{echo WEBSIZE .'qq50.jpg';} ?>');" />
					<div><?php  echo $item['nick'] ;?></div>
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				<!--需要用Php替换-->
				</li>
				
			<?php } ?>	
				
				
			</ul>
		</div><!--/friends-->
	</div><!--/left-->
	<div class="right">
			<div class="user clearfix">
		<div class="l">
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<img src="<?php if( !empty($uinfo['data']['head'])){echo $uinfo['data']['head'].'/50';}else{echo WEBSIZE .'qq50.jpg';} ?>" />
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<!--需要用Php替换-->
		</div>
		<dl><!--需要用Php替换-->
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<dt><?php echo $uinfo['data']['nick'] ;?></dt>
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<!--需要用Php替换-->
			<dd><!--<a href="logout.php">[退出]</a>--></dd>
		</dl>
	</div>
<dl class="hot">
	<dt>广告barners:</dt>
	</dl>
<!--<dl class="hot">
	<dt>你玩过：</dt>
		<dd><span>·</span><a href="">你今生的感情路</a><div class="n">(人气：2,648,289)</div></dd>
	</dl>-->
	</div>
</div><!--/main-->
<div class="footer">
	Copyright &copy;2012 Ci123.com. All Rights Reserved
</div><!--/footer--><form name="pubForm" action="chuli.php" method="post">
	<input type="hidden" name="username" />
	<input type="hidden" name="nickname" />
	<input type="hidden" name="head" />
	<input type="hidden" name="gz" value=0 />
</form>
<script language="javascript">
function pubPost(username,nickname,head){
	var f = document.pubForm;
	f.username.value = username;
	f.nickname.value = nickname;
	f.head.value = head;
	f.submit();
}

function followMe(v)
{
        if(v){
        document.pubForm.gz.value=1;
        }else
        {
        document.pubForm.gz.value=0;
        }
}
</script>
<div style="display:none"><script src="http://s96.cnzz.com/stat.php?id=3764957&web_id=3764957" language="JavaScript"></script></div>
</body>
</html>
