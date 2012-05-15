//触发显示评论内容
$(function () {
	$('.insert_comment_button').click(function () {
		var mid = $(this).attr('alt');
		var newThis = $(this).parent().parent().siblings('.commentbox');
			if(!newThis.siblings('.retweetbox').hasClass('hide'))
			{
				newThis.siblings('.retweetbox').toggleClass('hide');
			}
			
			if(newThis.attr('title') == 'added')
			{
				newThis.toggleClass('hide');
				
			}
			else
			{
				$.ajax({
				    type: "POST",
				    url: ajaxUrl,
				    data: "weibomid="+mid,
				    success: function(msg){
				    	comment[mid] = msg;
				    	newThis.append(comment[mid]);
				    }
				 });
				 newThis.toggleClass('hide').attr('title','added');
			}
	});
});


//触发显示转发框

$(function () {
	$('.insert_retweet_button').click(function () {
		var newThis = $(this).parent().parent().siblings('.retweetbox');
		if(!newThis.siblings('.commentbox').hasClass('hide'))
		{
			newThis.siblings('.commentbox').toggleClass('hide');
		}
		newThis.toggleClass('hide');
	});
});


//在转发里输入表情
$('.retweet_biaoqing_trigger').click(function () {
	var newThis = $(this).parent().siblings('.retweet_biaoqing_floatbox');
	newThis.toggleClass('hide');
})

$('.retweet_biaoqing_img img').click(function () {
	var thisTextarea = $(this).parent().parent().parent().siblings('form').children('.retweet_box_text');
	var nowContent = thisTextarea.val();
	thisTextarea.attr('value',nowContent+$(this).attr('alt'));
	$(this).parent().parent().parent('.retweet_biaoqing_floatbox').toggleClass('hide');
})

//提交转发
$('.retweet_box_button').click(function(){
	var thisContent = $(this).siblings('.retweet_box_text').val();
	var newThis = $(this).parent().parent('.retweetbox');
	var thisId = newThis.attr('alt');
	$.ajax({
	    type: "POST",
	    url: ajaxUrl,
	    data: {zhuanfaid:thisId,zhuanfa:thisContent},
	    success: function(){
	    	alert('转发成功');
	    }
	 })
	$(this).siblings('.retweet_box_text').attr('value','');
})