var checkAlready = "on",
	alreadyPass = "";
function clearAlert() {
	$("#alertyes").hide();
	$("#alertno").hide();
	$("#alertpass").hide();
	$("#alert").hide();
	$("#alertmailno").hide();
	$("#passok").hide();
}

$("input").focus(function () {
	clearAlert();
})
function isEmail(str){
       var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
       return reg.test(str);
}

function submitClick() {
	if(checkAlready == "on"){
		if(MD5($(".password2").val()) == alreadyPass){
			$("#button").trigger("click");
		}else{
			alert("你输入的密码不正确,请重新输入!");
		}
	}else{
		if($("#email").val() == "" || $("#password").val() == ""){
			$("#alert").fadeIn(300);
		}else if(isEmail($("#email").val())){
			$("#button").trigger("click");
		}else{
			$("#alert").fadeIn(300);
		}
	}
}
$("#submit").bind("click",submitClick);
		
$("#password").focus(function () {
	$("#alertpass").hide();
})
$("#repassword").focus(function () {
	$(this).blur(function () {
		if($("#password").val() != $("#repassword").val()){
			$("#alertpass").fadeIn(200);
			$("#submit").unbind("click");
		}else if($("#password").val() == $("#repassword").val() && $("#password").val() != ""){
			$("#passok").fadeIn(200);
			$("#submit").bind("click",submitClick);
		}
	})
})
$("#email").focus(function () {
	$("#alertyes").hide();
	$("#alertno").hide();
	$(this).blur(function () {
		if(isEmail($("#email").val())){
			$.ajax({
				type:"POST",
				url:"checkemail.php",
				data:{email:$(this).val()},
				beforeSend:function () {
					$("#loading").show();
				},
				success:function (data) {
					$("#loading").hide();
					if(data == "true"){
						checkAlready = "off";
						$("#alertyes").fadeIn(300);
						$("#alreadybox").hide();
						$("#hideform").show();
						$("#submit").bind("click",submitClick);
					}else{
						checkAlready = "on";
						alreadyPass = data;
						$("#hideform").hide();
						$("#alreadybox").show();
					}
				}
			})
		}
		if($("#email").val() != "" && !isEmail($("#email").val())){
			$("#alertmailno").fadeIn(200);
		}
	})
})