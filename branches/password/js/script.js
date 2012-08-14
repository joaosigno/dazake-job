$(function(){
	$('#gen').click(function(){
		var secure =  $('#security').val().split(''),
			subSecure = secure,
			keyword = secure.concat(subSecure);
		$.ajax({
			type:"POST",
			url:"password.php",
			data:{sendData1:$('#password').val(),sendData2:keyword},
			beforeSend:function () {
				$('#loading').fadeIn();
			},
			success:function (data) {
				$('#loading').hide();
				$('#result').text(data).fadeIn();
			}
		});
	});

	$('#clear').click(function(){
		$('input').val('');
		$('#result').fadeOut();
	})
});