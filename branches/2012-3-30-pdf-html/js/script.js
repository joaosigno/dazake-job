/* Author:Bryant Chan

*/
(function($){
	$(function(){
		var thisHeight = parseInt($("#main").css('height'));
		var Input;
		var signOptions = {
			drawOnly:true,
			clear: "#signclear"
		};

		$('#pdfbox').load('pdf1.html');
		$('#signbox').signaturePad(signOptions);
		$('#slider').slider();
		$("#main").css({
			'height': thisHeight - 121
		});

		$('.inputTools').click(function(){
			Input = new PDF($(this).attr('id'));
		});

		$('body').on('click','.confirm',function(){
			Input.confirmEl();
		});

		$('body').on('click','.delete',function(){
			Input.removeEl();
		});

		$('#signature').bind('click',function(){
			$('#signbox').slideToggle();
		});

		$('#signcancel').click(function(){
			$('#signbox').slideUp();
		});

		$("#signok").click(function(){
			var img = $('.output').val();
			$.ajax({
				type:"POST",
				url:"test.php",
				data:{output:img},
				beforeSend:function () {
					// console.log('ddd');
					$("#loadingbar").show();
				},
				success:function (data) {
					// $('#pdfbox').trigger('picready');
					$("#loadingbar").hide();
					Input = new PDF('signok', data);
					console.log(data);
					$('#signbox').hide();
				}
			})
		})
	})
})(jQuery);




