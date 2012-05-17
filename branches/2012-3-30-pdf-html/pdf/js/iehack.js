(function($){
	$(function(){
		$("img").each(function(){
			var temp = $(this).attr('src');
			$(this).attr('src', temp + "?" + new Date().getTime());
		});
	});
})(jQuery);