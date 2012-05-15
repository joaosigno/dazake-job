<?php
	session_start();
	// 有$_POST【command】请求时候对应修改session值
	// $_POST['command']['uid'] = 234707;
	// $_POST['command']['id'] = 234707623;
	// $_POST['command']['type'] = 'friendchange';
	
	if(isset($_POST['command'])){
		//session控制
		if(isset($_POST['command']['type'])){
			switch ($_POST['command']['type']){
				case 'friendchange':  //用户朋友更改
					$_SESSION['friendname'] = $_POST['command']['uid'] ; //更改朋友id
					$_SESSION['name'] = $_POST['command']['id'] ; //主用户id
					$_SESSION['page'] = 1 ; //初始化page回1
					$_SESSION['searchbytime'] = 1 ;//初始化按时间按搜索为所有记录
  					break; 	
				case 'nav': //聊天记录浏览导航
					switch($_POST['command']['func']){
						case 'index': //首页设置page为1
							$_SESSION['page'] = 1;
  							break;
						case 'prev': //上一页page-1
							$_SESSION['page'] = $_SESSION['page'] >1 ? $_SESSION['page'] -1 : $_SESSION['page'] ;
  							break;
						case 'next': //下一页page+1
							$_SESSION['page'] = $_SESSION['page'] +1 ;
							if(isset($_SESSION['lastpage'])){
								$_SESSION['page'] = min($_SESSION['lastpage'],$_SESSION['page']);
							}
  							break;
						default:
							$_SESSION['page'] = 1;
						}	
  					break;	
				case 'delete': //按id删除记录
					$deletenumber = $_POST['command']['mid'];
  					break;
				case 'searchbytime': //按时间查找
					$_SESSION['searchbytime'] = strtotime($_POST['command']['year'].'-'.$_POST['command']['month'].'-'.$_POST['command']['day']);
					$_SESSION['page'] = 1;//页数初始化1
  					break;
				default:
					return true;
			}
		}		
	}else{
		$_SESSION['searchbytime'] = 1;
		$_SESSION['page'] = 1;//页数初始化1
	}
?>