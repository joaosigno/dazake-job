$(function () {	
			type:"POST",
			url:"chuli.php",
			data:{sendString:anwserStorage,point:total,message:count(total)},
			beforeSubmit:function () {},
			success:function () {
				$("#callback").fadeIn();
			}
		})