<?php	
//用户状态保存在$zt数组里面
	$zt = $client->POST('status.gets',array('',MESSAGE_COUNT,$_GET['page']));
?>