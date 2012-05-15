<?php		
		require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR  . 'requires.php');
		require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR .  'mcontrol.php');
		$db = new DB();
		
		//有删除就执行删除功能
		if(isset($deletenumber)){
			$sql = "DELETE FROM ".DAPRE."message WHERE id = " . $deletenumber;
			$db->query($sql);
		}
		
		
		if(isset($_SESSION['name']) && isset($_SESSION['friendname'])){
		
		
			// 获取总聊天记录数
			$sql = "select count(*) as result_num from chatlog_message where fromname = ".$_SESSION['name']." and toname = ".$_SESSION['friendname']." and parentusername = '".$_SESSION['parentusername']."'";
			$result = $db->get_one($sql);
		
			// 当结果为0，自动初始化为小于一页的记录
			if($result['result_num']>0)
				$pg = new page(10,$result['result_num']);
			else
				$pg = new page(10,1);
			
		
			// 获取用户与好友聊天记录
			$sql = "select *  from chatlog_message where fromname = ".$_SESSION['name']." and toname = ".$_SESSION['friendname']." and parentusername = '".$_SESSION['parentusername']."'and time > ".$_SESSION['searchbytime']." order by time desc LIMIT ".$pg->show_page_result() ." , 10";
			$message = $db->get_all($sql);
		}
			// 处理返回结果给前台
			foreach($message as $key => $item){
				// 返回主说话者姓名与被说话者姓名
				if($item['flag'] ){
					$item['fromname'] = $_SESSION['name'] ;
					$item['toname'] = $_SESSION['friendname'] ;
				}
				else{
					$item['fromname'] = $_SESSION['friendname'] ;
					$item['toname'] = $_SESSION['name'] ;
				}
			
				$displaymessage[$key]['fromname'] = $item['fromname'];
				$displaymessage[$key]['toname'] = $item['toname'];
				$displaymessage[$key]['message'] = $item['message'];
				$displaymessage[$key]['time'] = date('Y-m-d h:i:s',$item['time']);//记录时间
				$displaymessage[$key]['messageid'] = $item['id']; //聊天记录唯一id
			}
		
			if(isset($displaymessage)){
				echo json_encode($displaymessage);
			}
			else{
				$displaymessage[0]['fromname'] = 'admin';
				$displaymessage[0]['toname'] = $_SESSION['name'];
				$displaymessage[0]['message'] = '系统提示你，'.$_SESSION['name'].'和'.$_SESSION['friendname'].'还没有聊天记录。';
				$displaymessage[0]['time'] = date('Y-m-d h:i:s',time());//记录时间
				$displaymessage[0]['messageid'] = time(); //聊天记录唯一id
				echo json_encode($displaymessage);
			}
?>