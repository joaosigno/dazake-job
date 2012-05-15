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

	

	

	if(isset($_SESSION['access_token']) && isset($uinfo['nickname']) && isset($_SESSION["openid"]) && isset($_POST['email']) && isset($_POST['password'])){

		

		$email = mysql_real_escape_string(stripslashes($_POST['email']));

		$sql = $sql = "SELECT `id`  FROM `users` WHERE `email` = '" . $email . "'";

		$email_result = $db->get_one($sql);

		

		$openid = mysql_real_escape_string(stripslashes($_SESSION["openid"]));//openid 唯一标记作为唯一标记

		$sql = "SELECT *  FROM `users` WHERE  `openid` = '".$openid."'";

		$result = $db->get_one($sql);

		

		

		

		if(!$result && !$email_result){

		// echo '用户还没入库';

			$arr_in = array();

			$arr_in['username'] = mysql_real_escape_string(stripslashes($uinfo['nickname']));

			$arr_in['nickname'] = mysql_real_escape_string(stripslashes($uinfo['nickname']));

			$arr_in['gender'] = mysql_real_escape_string(stripslashes(($uinfo['gender'] ==  '男' ? 'male':'female')));

			$arr_in['usertype'] = mysql_real_escape_string(stripslashes(2));

			$arr_in['password'] = md5(mysql_real_escape_string(stripslashes($_POST['password'])));

			$arr_in['email'] = mysql_real_escape_string(stripslashes($_POST['email']));

			$arr_in['openid'] = mysql_real_escape_string(stripslashes($openid));

			$arr_in['birthday'] = mysql_real_escape_string(stripslashes('1900-01-01'));

			

			$img_name = 'qqhead'.time().rand(0,100) . '.jpg';

			$filename = '../../images/profile_pics/'.$img_name;

			

			$url = $uinfo['figureurl_1']; 

			$result_get_img = getImg($url, $filename);

			

			if($result_get_img){

				$arr_in['profile_pic'] = mysql_real_escape_string(stripslashes('images/profile_pics/'.$img_name));

			}



		

			$result = $db->insert('users',$arr_in);

			

			if($result){

				header("Location: control.php");

			}

		}

		

		//有email and password

		if($email_result && isset($_POST['password'])){

			$email = mysql_real_escape_string(stripslashes($_POST['email']));

			$password = md5(mysql_real_escape_string(stripslashes($_POST['password'])));

			$sql = $sql = "SELECT `id`  FROM `users` WHERE `password` = '".$password."' AND `email` = '" . $email . "'";

			$email_password_result = $db->get_one($sql);

			

			//邮件密码正确

			if($email_password_result){

				$openid = mysql_real_escape_string(stripslashes($_SESSION["openid"]));

				$sql = "UPDATE `users` SET  `openid` =  '".$openid."' WHERE  `users`.`id` = '".$email_password_result['id']."' ";

				$user_update_result = $db->query($sql);

				

				if($user_update_result){

					header("Location: control.php");

				}

			}

		}

	}

?>