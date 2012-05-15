$(function () {
	var currentQuiz = $("#currentNum").html();//当前题目数；
	var yanwser = 0;						  //选择YES答案的个数；
	var manwser = 0;						  //选择Normal答案的个数；
	var nanwser = 0;						  //选择NO答案的个数；
	var maleans = 0;						  //选择男性就返回1；
	//选择男性就返回1；
	$(".male").click(function () {
		maleans++;
	})
	//选择YES答案+1；
	$(".yes").click(function () {
		yanwser++;
	})
	//选择Normal答案+1；
	$(".mid").click(function () {
		manwser++;
	})
	//选择No答案+1；
	$(".no").click(function () {
		nanwser++;
	})
	//点击选项后进入下一页；
	$('.item').click(function () {
		currentQuiz++;
		$("#currentNum").html(currentQuiz);
//		$(this).children('input').attr("checked",true);
		$(this).parents(".eachQuiz").hide();
		$(this).parents(".eachQuiz").next(".eachQuiz").fadeIn(300);
	})
	//弹出层
	$("#tweet").click(function () {
		$("#alertbg").show();
		$("#alertbox").show();
	})
	//取消显示弹出层
	$("#cancel").click(function () {
		$("#alertbg").fadeOut(500);
		$("#alertbox").fadeOut(500);
	})
	//选择关注官方微博
	$("#sendYes").click(function () {
		sendData(1);
		$("#alertbg").hide();
		$("#alertbox").hide();
	})
	//选择不关注官方微博
	$("#sendNo").click(function () {
		sendData(0);
		$("#alertbg").hide();
		$("#alertbox").hide();
	})
	//传送数据函数，传入是否关注官网微博的参数（1：关注，0：不关注）
	function sendData(guanzhu) {
		var thisYear = $("#year").val();			//出生年龄
		var thisMonth = $("#month").val();			//剩余月份
		var thisDay = parseInt(Math.random()*10);	//剩余日
		var thisMoment = parseInt(Math.random()*10);//剩余分
		var thisSecond = parseInt(Math.random()*10);//剩余秒
		var maleAge = 75;							//男人平均寿命
		var femaleAge = 80;							//女人平均寿命
		var nowAge;									//剩余年份
		var guanzhu;								//是否关注官方微博
		
		$("#loading").show();
		if(maleans)
		{
			nowAge = maleAge-(2011-thisYear)+(parseInt(nanwser*(-0.5)))+yanwser;
		}
		else 
		{
			nowAge = femaleAge-(2011-thisYear)+(parseInt(nanwser*(-0.5)))+yanwser;
		}
		$.ajax({
			type:"POST",
			url:"chuli.php",
			data:{
				nowAge:nowAge,
				thisMonth:thisMonth,
				thisDay:thisDay,
				thisMoment:thisMoment,
				thisSecond:thisSecond,
				guanzhu:guanzhu
			},
			beforeSubmit:function () {},
			success:function () {
				location.href ="last.php";
			}
		})
	}
})