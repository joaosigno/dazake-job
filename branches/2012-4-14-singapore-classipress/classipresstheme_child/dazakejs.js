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
			this.space = 180;
			this.interval = 2500;
			this.t = "";
			this.dir = true;
			this.el.css('width',this.width);
			this.start();
		},
		start: function(){
			var self = this;

			this.t = setInterval(function(){
				var thisMargin = parseInt(self.el.css('margin-left'));
				// console.log(self.el.length);
				
				self.el.animate({'margin-left': thisMargin-self.space});

				if( Math.abs(thisMargin) >  (self.el.length - 7) * self.space){ self.reverse(); }
			}, this.interval);
		},
		stop: function(){
			clearInterval(this.t);
		},
		reverse: function(){
			// this.dir = !this.dir;
			this.el.animate({'margin-left': 0});
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
			$('.dazakeactive').append(last);	
			if ($('.dazakeactive').queue("fx").length == 0){
				$('.dazakeactive div:last').show();
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