<?php
	session_start();
	require_once ('../class/requires.php');
	if(isset($_POST['passwd'])){
		if( trim($_POST['userName']) == USERNAME && md5(trim($_POST['passwd'])) == PASSWORD){
			$_SESSION['houtai_login'] = true;
			header("Location: list.php");

		}
	
	}
?>

		<input type="password" name="passwd" class="inputarea" value=""/>
	</form>