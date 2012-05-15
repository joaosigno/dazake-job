<?php	
	require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR .  'mcontrol.php');
	$db = new DB();	
	$friends = array();	
	
	// print_r($_SESSION['account']);
	
	//获取用户好友列表
	if(isset($_SESSION['account'])){
		foreach($_SESSION['account'] as $key=>$item){
			$sql = " SELECT `id` , `toname` FROM `".DAPRE."friend` WHERE `fromname` = ".$item['name']."  and `parentusername` = '".$_SESSION['parentusername']."'";
			$friend = $db->get_all($sql);
			
			//修改id和name
			foreach($friend as $kr => $fr){
				$friend[$kr]['touid'] = $fr['toname'];
				$friend[$kr]['name'] = $fr['toname'];
				$friend[$kr]['id'] = $fr['toname'];
			
			}
			
			$friends[$key] = $friend;
			$friends[$key]['name'] = $item['name'];
			$friends[$key]['id'] = $item['name'];//id已经没有用了。现在以name来查找
		
		}			//echo json_encode($friends[0]);
			echo json_encode($friends);
			// print_r($friends);
	}
?>