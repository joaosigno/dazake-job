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
	<title>人人网微博应用</title>	<style type="text/css">	body {
		behavior:url("../css/csshover3.htc");
	}	</style>
</head>
<body>
	<div id = 'content'>
		<p id="title">问卷调查数据整理</p>		<?php
			$th = 3;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">是否希望在毕业时和同学朋友拍摄视频留念?</div>			<div class="eachanwser"><span class="inspector">•</span>是<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>否<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>				</div>
		
		<?php
			$th = 4;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">毕业视频可以接受的价格范围</div>			<div class="eachanwser"><span class="inspector">•</span>100~500元<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"   class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>只要做的好500元以上可以接受<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"   class="detail">查看详情</a></div>		</div>
		
		<?php
			$th = 6;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">20年后回想大学生活，你觉的什么最值得你怀念？</div>			<div class="eachanwser"><span class="inspector">•</span>老师和同学<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>一件难忘的事<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>校园爱情<span id="percentage"><?php echo $choise[3] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=3"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>四年的经历<span id="percentage"><?php echo $choise[4] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=4"  class="detail">查看详情</a></div>		</div>
		
		
		<?php
			$th = 7;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">参加了几个社团?</div>			<div class="eachanwser"><span class="inspector">•</span>0个<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>1个<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>2个<span id="percentage"><?php echo $choise[3] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=3"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>3个以上<span id="percentage"><?php echo $choise[4] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=4"  class="detail">查看详情</a></div>		</div>
		
		
		<?php
			$th = 11;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">大学爱情是纯洁美丽的，你是否希望用视频把你们的爱情记录下来？</div>			<div class="eachanwser"><span class="inspector">•</span>很愿意（可以公开）<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>还可以（但不要公开）<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>不太愿意<span id="percentage"><?php echo $choise[3] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=3"  class="detail">查看详情</a></div>		</div>
		
		
		<?php
			$th = 13;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">会摄像或后期制作吗？</div>			<div class="eachanwser"><span class="inspector">•</span>都会<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>只会一样<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>都不会<span id="percentage"><?php echo $choise[3] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=3"  class="detail">查看详情</a></div>		</div>
		
		
		<?php
			$th = 16;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">把你的大学生活做成一个几分钟的视频缩影，你是否会积极配合？你认为多少价钱合适</div>			<div class="eachanwser"><span class="inspector">•</span>会，1000以内<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>会，1000~2000以内<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>会，2000~4000以内<span id="percentage"><?php echo $choise[3] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=3"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>不会<span id="percentage"><?php echo $choise[4] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=4"  class="detail">查看详情</a></div>		</div>
		
		<?php
			$th = 19;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">是否是社团的干部或者班级的干部？</div>			<div class="eachanwser"><span class="inspector">•</span>是，我认为自己很负责，并有一定的号召力<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>是，但我不太负责<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>不是<span id="percentage"><?php echo $choise[3] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=3"  class="detail">查看详情</a></div>		</div>		
		
		<?php
			$th = 24;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">如果想拍视频留念是希望整个班级一起还是和自己的好朋友拍?</div>			<div class="eachanwser"><span class="inspector">•</span>班级一起拍<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>和好朋友一起<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>都想<span id="percentage"><?php echo $choise[3] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=3"  class="detail">查看详情</a></div>		</div>
		
		
		<?php
			$th = 27;
			$sql = "select `$th` , count(*) as choise from answers group by `$th` order by `$th` LIMIT 0, 30 ";
			$result = $db->get_all($sql);
			
			for($i =1 ; $i<= 5 ; $i++)
				$choise[$i] = 0 ;
			
			for($i = 1; $i<= count($result) ; $i++){
					$choise[$result[$i-1][$th]] = $result[$i-1]['choise'];
			}
		?>		<div class="eachitem">			<div class="eachquiz">社团组织学校之间的男女联谊活动，你是否会积极组织或积极参加？</div>			<div class="eachanwser"><span class="inspector">•</span>会<span id="percentage"><?php echo $choise[1] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=1"  class="detail">查看详情</a></div>			<div class="eachanwser"><span class="inspector">•</span>不会<span id="percentage"><?php echo $choise[2] .'/'. $num ;?></span><a href="detail.php?th=<?php echo $th ;?>&ch=2"  class="detail">查看详情</a></div>		</div>
	</div>
</body>