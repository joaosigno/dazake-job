$(function () {		var total = 0;	var anwserStorage = new Array();		anwserStorage[0] = "here's the anwser:";			$('.eachanwser').click(function () {		var newThis = $(this).parents('.eachquiz');		var thisQuiz;		newThis.hide().next('.eachquiz').fadeIn(400);		anwserStorage[newThis.attr("alt")] = $(this).index()+1;	})		$("#last").click(function () {		$("#last").hide();		$("#thank").html("请稍后");				for(var i=1;i<=27;i++){			total += point[i][anwserStorage[i]];		}				total = 100-total;				$.ajax({
			type:"POST",
			url:"chuli.php",
			data:{sendString:anwserStorage,point:total,message:count(total)},
			beforeSubmit:function () {},
			success:function () {				$("#thank").hide();				$("#point").append(total);				$("#feedback").append(count(total));
				$("#callback").fadeIn();
			}
		})	})})