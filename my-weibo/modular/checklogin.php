<?php
	session_start();
	if(isset($_SESSION['id'])&&isset($_SESSION['weibo_token']['access_token'])){
		include_once( './class/db.class.php' );
		include_once( './class/config.php' );
		include_once( './class/saetv2.ex.class.php' );
		$db = new DB();
		$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['weibo_token']['access_token'] );
		//读取用户信息
		$uid_get = $c->get_uid();
		
		// 获取不到信息。直接退出
		// if(!isset($uid_get['uid'])){
			// header("Location: modular/logout.php");
		// }
		
		$uid = $uid_get['uid'];
		$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
		$result = $c->my_handle();//动作响应
		$bq = $c->emotions();		//读取表情
	}else{
		header("Location: ./index.php");	
	}	
	//分页导航	
	if(!isset($_GET['page'])){
		$_GET['page']=1;
	}
?>