<?php

	session_start();

	require_once("class/requires.php");

	$is_act_user = false;

	

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

	

	//判断用户是否存在

	if( isset($_SESSION['access_token']) && isset($uinfo['nickname']) && isset($_SESSION["openid"])){

		$openid = mysql_real_escape_string(stripslashes($_SESSION["openid"]));//openid唯一标记

		$sql = "SELECT *  FROM `users` WHERE   `openid` = '".$openid."'";

		$result = $db->get_all($sql);

		$count = count($result);

		

		if(!$result){

			header("Location: register.php");

		}

		

		elseif($count==1){

		

			$_SESSION['username']= $result[0]['username'];

			$_SESSION['id']= $result[0]['id'];

			$_SESSION['email']= $result[0]['email'];

			$_SESSION['newlogin']="yes"; 

			$_SESSION['pw'] = $result[0]['password'];

			$is_act_user = true;

		}

	}

	

	if($is_act_user == true ){

		$rand = rand(0,100000);	

		$sql = "update users set code='".$rand."' WHERE   `openid` = '".$openid."'";

		$db->query($sql);

		// include_once('welcome_email.php');

		$_SESSION['LAST_CLICK'] = time();

		$cloud = 'http://' . $_SERVER['HTTP_HOST'] . '/cloud/';

		header("location: $cloud");

		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$cloud.'">';

	}

?>