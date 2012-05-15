$('.comment_biaoqing_trigger').click(function () {
	var newThis = $(this).parent().siblings('.comment_biaoqing_floatbox');
	newThis.toggleClass('hide');
})

$('.comment_biaoqing_img img').click(function () {
	var kkk = $(this).attr('alt');
	var thisTextarea = $(this).parent().parent().parent().siblings('form').children('.comment_text');
	var nowContent = thisTextarea.val();
	thisTextarea.attr('value',nowContent+$(this).attr('alt'));
	$(this).parent().parent().parent('.comment_biaoqing_floatbox').toggleClass('hide');
})

//评论一条微博
$('.comment_button').click(function(){
	var thisId = $(this).parent().parent().parent('.commentbox').attr('alt');
	var thisContent = $(this).siblings('.comment_text').val();
	var newThis = $(this).parent().parent().parent('.commentbox');
	$.ajax({
	    type: "POST",
	    url: ajaxUrl,
	    data: {pinglunid:thisId,neirong:thisContent,weibomid:thisId},
	    success: function(msg){
	    	comment[thisId+"kkk"]=msg;
	    	newThis.empty().append(comment[thisId+"kkk"]);
	    }
	 })
})