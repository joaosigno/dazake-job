(function($){
	$(function(){
		$('#xmlbutton').click(function(){
			var thisUrl = $('#xml-id').data('url');
			console.log(url);

			var thisData = {
				'id': $('#xml-id').attr('value'),
				'title': $('#xml-title').attr('value'),
				'link': $('#xml-link').attr('value'),
				'content': $('#xml-content').attr('value')
			}

			$.ajax({
				type:"POST",
				url:thisUrl,
				data:thisData,
				beforeSend:function () {},
				success:function () {
					
				}
			})
		});
	});
})(jQuery);