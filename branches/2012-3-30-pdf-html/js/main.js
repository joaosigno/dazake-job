
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
			$(".signature").jSignature({
				width:620,
				height:150,
				lineWidth:3
			});
			$('#datepicker').datepicker();
			$('body').trigger('addSignature');
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
		$('body').on('addSignature', function(){
			$('.signbox').each(function(){
				var $parent = $(this);
				$parent
					.find('.clicktosign')
						.bind('click', function(){
							$parent.find('.signpic').detach().end().find('.sign').show();
						})
						.end()
					.find('.signcancel')
						.bind('click', function(){
							$parent.find('.sign').hide();
						})
						.end()
					.find('.signclear')
						.bind('click', function(){
							$parent.find('.signature').jSignature('clear');
						})
						.end()
					.find('.signok')
						.bind('click', function(){
							$parent.find('.sign').hide();
							var img = '<img src="'+$parent.find(".signature").jSignature('getData')+'" class="signpic" />';
							$parent.append(img);
						});
			})
		});

		$('.fillTools span').click(function(){
			//add dropdown menu to filltools at the first time
			$(this).parent('.fillTools').siblings('.fillTools').children('.fillToolsMenu').hide();
			// $('.fillToolsMenu').hide();
			if(!$(this).siblings('.fillToolsMenu').hasClass('addMenu')){
				var thisType = $(this).data('type'),
						thisTpl = fillToolsTpl[thisType]();
				$(thisTpl).addClass('addMenu').insertAfter($(this)).hide().slideDown();
				// $(this).after(thisTpl).addClass('addMenu').hide();
			//toggle the menu
			}else{
				$(this).siblings('.fillToolsMenu').slideToggle();
			}
		});

		$('#pdfbox').on('mouseover', '.toolbox', function(){
			if(!$(this).hasClass('active')){
				$(this).find('.editPanel').show();
			};
		});

		$('#pdfbox').on('mouseout', '.toolbox', function(){
			if(!$(this).hasClass('active')){
				$(this).find('.editPanel').hide();
			};
		});

		//add a filltool
		$('.fillTools').on('click', '.addTool', function(){
			$(this).parent('.fillToolsMenu').hide();
			var $parent = $(this).parents('.fillToolsMenu'),
					arg = {'type': $parent.siblings('span').data('type')};

			//loop the value of the menu and save to arg object
			for (var i = 0; i < $parent.children('input').length; i++){
				var thisInput = $($parent.children('input')[i]);

				if(thisInput.attr('type') === 'radio' && thisInput.attr('checked') === undefined){thisInput = ''}	
				if(thisInput !== ''){
					arg[thisInput.data('kind')] = thisInput.val();
				}
			}

			new Toolbar(arg);
		});
		
	})
})(jQuery);




