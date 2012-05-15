<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/home.css" media="all" />	<link rel="stylesheet" type="text/css" href="http://www.dazake.com/css/txwbnl-fakehome.css" media="all" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<?php include_once('modular/header.php');?>
	<a href="logout.php" id="logout">退出</a>
	</div>
	<div id="container">
		<div id="top">
			<img src="img/logo.png" alt="" id="logo" /><span id="hit">人气：672993</span>
		</div>
		<div id="mid"><p>珍爱生命，健康生活，想知道你的寿命有多长吗？ 这是一个科学的测试，所有24个选项都必须完成！</p></div>
		<div id="bottom">
			<div id="status">已经完成：<span id="currentNum">0</span>/24</div>
			
			<div class="eachQuiz" id="quiz1">
				<div class="title">1、性别？</div>
				<div class="item yes male">
					<input type="radio" name="" id="" class="check_item"/>男
				</div>
				<div class="item no female">
					<input type="radio" name="" id="" class="check_item"/>女
				</div>
			</div>
			
			<div class="eachQuiz hide" id="quiz1">
				<div class="title">2、生日是什么时候？</div>
				<div class="item2">
					<select name="" id="year">
					<?php
						for ($year = 2011 ; $year >= 1930; $year--) {
							echo("<option value='$year'>$year</option>");
						}
					?>
					</select>
					年
					
					<select name="" id="month">
					<?php
						for ($month = 1 ; $month <13; $month++) {
							echo("<option value='$month'>$month</option>");
						}
					?>
					</select>
					月
					<div id="nextbutton" class="item yes">Next</div>
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">3、是否结婚？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>已婚
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>未婚
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">4、压力大吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>比较大
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不大
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">5、是否与亲人长期分离?</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>没有
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">6、每天睡眠时间?</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>少于6小时
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>大于6小时
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">7、经常超负荷工作吗?</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>没有
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">8、经常认为自己病了或老了?</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">9、每天抽烟数量?</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>每天抽10支烟以上
				</div>
				<div class="item mid">
					<input type="radio" name="" id="" class="check_item"/>每天抽40支烟以上
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不抽烟
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">10、每天饮茶吗?</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">11、每天饮用含咖啡因的饮品？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">12、每天饮用啤酒超过3杯或含酒精的饮品超过3杯或4杯白酒?</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">13、每天刷牙吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">14、经常不采取任何防晒措施、频繁晒日光浴？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">15、肥胖吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">16、每天食用未完全煮熟的肉吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">17、经常食用垃圾食品？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">18、喜食不健康的快餐？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">19、每天不止1次吃甜食？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>是
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不是
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">20、体育锻炼情况？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>长期不活动
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>每天锻炼至少30分钟
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">21、能保证至少每2天大便1次吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>能
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不能
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">22、定期做身体检查吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>有
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>没有
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">23、血压正常吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>正常
				</div>
				<div class="item mid">
					<input type="radio" name="" id="" class="check_item"/>血压有点偏高
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>血压高
				</div>
			</div>
			
			<div class="eachQuiz hide" id="">
				<div class="title">24、体内胆固醇高吗？</div>
				<div class="item yes">
					<input type="radio" name="" id="" class="check_item"/>高
				</div>
				<div class="item no">
					<input type="radio" name="" id="" class="check_item"/>不高
				</div>
			</div>
			
			<div class="eachQuiz hide" id="back">
				<div id="loading" class="hide"><img src="img/loader.gif" alt="" />正在发送，请稍等</div>
				<div id="finish">测试已经结束，请将结果发布到腾讯微博！</div>
				<div id="tweet"></div>
				<div id="alertbox" class="hide">
					<span id="alert">是否关注我们的官方微博以便及时知道最新应用动态？<span id="cancel"></span></span>
					<div class="sendData" id="sendYes">是</div>
					<div class="sendData" id="sendNo">否</div>
				</div>
			</div>
			
			
			
		</div>
	</div>
	<?php include_once('modular/footer.php');?>
</body>
</html>