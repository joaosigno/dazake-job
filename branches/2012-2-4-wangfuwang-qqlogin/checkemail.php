<?php

	session_start();

	require_once("class/requires.php");

	

	if(isset($_POST['email']) && isset($_SESSION["openid"]) ){

		$email = mysql_real_escape_string(stripslashes($_POST['email']));

		$sql = $sql = "SELECT `password`  FROM `users` WHERE `email` = '" . $email . "'";

		$email_result = $db->get_one($sql);

		

		if(!$email_result){

			echo("true");

		}else{

			echo($email_result['password']);

		}

	}

?>