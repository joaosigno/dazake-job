<?php
	session_start();
	if(!$_SESSION['houtai_login'])
		header("Location: index.php");
		
	require_once ('../class/requires.php');
	include_once('../class/db.class.php');
	$db = new DB();
	
	$sql = "select count(*) as result_num from answers";
	$result = $db->get_one($sql);
	$num = $result['result_num'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/list.css" media="all" />
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<title>人人网微博应用</title>
		behavior:url("../css/csshover3.htc");
	}
</head>
<body>
	<div id = 'content'>
		<p id="title">问卷调查数据整理</p>
			$th = 3;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		<?php
			$th = 4;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		<?php
			$th = 6;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		
		<?php
			$th = 7;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		
		<?php
			$th = 11;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		
		<?php
			$th = 13;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		
		<?php
			$th = 16;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		<?php
			$th = 19;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		<?php
			$th = 24;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
		
		
		<?php
			$th = 27;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>
	</div>
</body>