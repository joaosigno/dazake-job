<?php
	include_once('../class/db.class.php');
	$db = new DB();
	
	

	
	$_POST['json_en']['uid'] = time()%1024 ;
	$_POST['json_en'][1] = time()%1024 ;
	$_POST['json_en'][2] = time()%1024 ;
	$db->insert('answers',$_POST['json_en']);






?>