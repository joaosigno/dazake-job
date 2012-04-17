jQuery(document).ready(function(jQuery){
	var $ = jQuery;
	var first = 0;
	var speed = 1000;
	var pause = 3500;
	var interval="";

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
		
	$('ul#listticker1').hover(function(){
			dazakeStop();
		}, function(){
			dazakeStart();
	});

	dazakeStart();
	
	$('.tabnavig li a').click(function(){
		var tabName = $(this).attr('href').slice(1,7);
		$('.dazake_slideup_block').removeClass('dazakeactive');
		$('#'+tabName).children('.dazake_slideup_block').addClass('dazakeactive');
	})
	//interval = setInterval(removeFirst, pause);
});