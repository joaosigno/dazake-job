
/* Author:Bryant Chan

*/
(function($){
	$(function(){

		// resize the height of the window
		var thisHeight = parseInt($("#main").css('height'));
		var pdfboxWidth = parseInt($('#pdfbox').css('width'));
		var windowWidth = parseInt($(document).width());
		var time = 0;

		$("#main").css({

			'height': thisHeight - 121
		});

		$('body').css({
			'width': windowWidth + 15
		})
		//re-center the pdfbox
		$('#pdfbox').css({
			'margin-left': -(pdfboxWidth / 2)
		});


		//for zoom slider
		var direction = true;
		function pdfResize(size){
			var api = $('#pdf').jScrollPane().data('jsp');
			api.destroy();

			$('#pdfbox .pdf').each(function(){
				$(this).attr('src','images/pdf/'+size+'/'+$(this).attr('alt'));
			});

			$('#pdfbox').animate({
				'width': size,
				'margin-left': -(size / 2)
			}, function(){
				$('#pdf').jScrollPane();
			});

			

		}


		function pdfZoom(dir){
			var thisVal = $("#slider").slider("value");
			direction = dir;
			$('#slider').slider("value", (dir) ? thisVal += 80 : thisVal -= 80);
			switch(thisVal){
				case 960:
					$("#zoomin").attr('data-zoomable', 'false').css('color','#ddd');
					break;
				case 640:
					$("#zoomout").attr('data-zoomable', 'false').css('color','#ddd');
					break;
				default:
					$('.zoom').attr('data-zoomable', 'true').css('color','#4091A9');
					break;
			}
		}

		$('#slider').slider({
			max: 960,
			min: 640,
			value: 800,
			step: 80,
			change: function(){
				pdfResize($(this).slider("value"));
				time++;
			}
		});

		$('.zoom').click(function(){
			if($(this).attr('data-zoomable') !== 'false'){
				pdfZoom($(this).text() === "+");
			}
		});

		$('#fixed').click(function(){
			if($('#zoomin').attr('data-zoomable') !== 'false'){
				$('#slider').slider("value", '960');
				direction = false;
				$("#zoomin").attr('data-zoomable', 'false').css('color','#ddd');
				$("#zoomout").attr('data-zoomable', 'true').css('color','#4091A9');
				// $('#pdfbox .form').each(function(){
				// 	var thisHeight = $(this).css('top');
				// 	$(this).css({
				// 		'top': (parseFloat(thisHeight) + 0.15) + "%"
				// 	});
				// });
			}
		})

		//jscrollPanel when all the images are loaded
		$('img').load(function(){
			if(time === 0){
				$('.scroll-pane').jScrollPane();
			}
		});

		$('#form1').empty().load('form1.html', function(){
			$("#signature").jSignature({
				width:620,
				height:150,
				lineWidth:3
			});
			$('#datepicker').datepicker();
		});
		

		// toggle preview panel
		function togglePreview(status){
			var api = $('#pdf').jScrollPane().data('jsp');
			api.destroy();

			$('#preview').animate({
				'width': ( (status) ? '0' : '15%' )
			});
			$('#pdf').animate({
				'width': ( (status) ? '99.9%' : '84.9%' )
			}, function(){
				$('#pdf').jScrollPane();
				$('#preview-panel').data('panel', ((status) ? 'colse' : 'open') );
			});
		}

		$('#preview-panel').click(function(){
			togglePreview( $(this).data('panel') === 'open');
		});

		$('.preview').click(function(){
			var api = $('#pdf').jScrollPane().data('jsp');
			api.scrollToElement($($(this).data('img')), true);
		})

		//fill form
		$("body").on('click', '.checkbox', function(){
			var thisStatus = $(this).children('input').attr('checked');
			$(this).children('span').text((thisStatus === "checked") ? " " : "✔");
			if(thisStatus === "checked"){
				$(this).children('input').removeAttr('checked');
			}else{
				$(this).children('input').attr('checked', 'checked');
			}
		});

		$("body").on('click', '.radio', function(){
			var thisStatus = $(this).children('input').attr('checked');
			$(this).children('span').text((thisStatus === "checked") ? "" : "●");
			if(thisStatus === "checked"){
				$(this).children('input').removeAttr('checked');
			}else{
				$(this).children('input').attr('checked', 'checked');
			}
		});

		//signature

		$("body").on('click', '#signbox #clicktosign', function(){
			$('#signpic').detach();
			$('#sign').show();
		});

		$("body").on('click', '#signcancel', function(){
			$('#sign').hide();
		});

		$("body").on('click', '#signclear', function(){
			$("#signature").jSignature('clear');
		});

		$("body").on('click', '#signok', function(){
			$('#sign').hide();
			var img = '<img src="'+$("#signature").jSignature('getData')+'" id="signpic" />';
			$('#signbox').append(img);
		});

		
	})
})(jQuery);




