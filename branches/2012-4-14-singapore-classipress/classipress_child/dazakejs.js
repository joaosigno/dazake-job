jQuery(document).ready(function(jQuery){
	var $ = jQuery;
	var first = 0;
	var speed = 1000;
	var pause = 3500;
	var interval="";

	var dazakeSlider = {
		init: function(){
			this.el = $("#dazake-mid-slider");
			this.el.length = this.el.children('a').length;
			this.width = (this.el.length+2) * 200;
			this.interval = 3000;
			this.t = "";
			this.el.css('width',this.width);
			self = this;
			this.start();
			
		},
		
		start: function(){
			self.t = setInterval(self.removeFirst, self.interval);
			self.removeFirst();
		},

		stop: function(){
			clearInterval(self.t);
		},

		removeFirst: function(){
			self.temp = $("#dazake-mid-slider a:first");
			$("#dazake-mid-slider a:first").animate({
				'width': 0
			}, function(){
				$(this).remove();
				dazakeSlider.addToLast(self.temp);
			});
			
		},

		addToLast: function(last){
			self.el.append(last);	

			$("#dazake-mid-slider a:last").css('width', '180');
		}
	}

	function removeFirst()
	{		
			first = $('.dazakeactive div:first').html();
			if (($('.dazakeactive').queue("fx").length) == 0)
			{
				$('.dazakeactive div:first').slideToggle('slow', function() 
				{
					$(this).remove();
				});
				addLast(first);
			}
	}
		

	function addLast(first){
			last = '<div class="post-block-out" style="display:block">'+first+'</div>';
			if($('.dazake_slideup_block').hasClass('dazake-fixed')){
				$('.paging').before(last);	
				if ($('.dazakeactive').queue("fx").length == 0){
					$('.dazakeactive div:last').show();
				}
			}else{
				$('.dazakeactive').append(last);	
				if ($('.dazakeactive').queue("fx").length == 0){
					$('.dazakeactive div:last').show();
				}
			}
	}

	function dazakeStop()
	{
		if (interval != ""){
			clearInterval(interval);
			interval = "";
		}
	}
	
	function dazakeStart()
	{
			if ((interval == ""))
				interval = setInterval(removeFirst, pause);
			else dazakeStop();
	}
		
	$('.dazakeactive').hover(function(){
			dazakeStop();
		}, function(){
			dazakeStart();
	});

	
	dazakeStart();

	if($("#dazake-mid-slider a").length > 5){dazakeSlider.init();}
	$('#dazake-mid-slider').mouseover(function(){
		dazakeSlider.stop();
	});
	$('#dazake-mid-slider').mouseout(function(){
		dazakeSlider.start();
	});
	// console.log($("#dazake-mid-slider img").length);
	
	$('.tabnavig li a').click(function(){
		var tabName = $(this).attr('href').slice(1,7);
		$('.dazake_slideup_block').removeClass('dazakeactive');
		$('#'+tabName).children('.dazake_slideup_block').addClass('dazakeactive');
	})
});