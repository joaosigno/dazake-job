//新鲜事喜欢功能
var ajaxLike = "modular/ajax_like.php";
//新鲜事分享功能
var ajaxShare = "modular/ajax_share.php";
//发表评论
var ajaxAddComment = "modular/ajax_addcomment.php";
//上传图片
var ajaxPhoto = "modular/ajax_photo.php";

$(function () {
	//点击状态、图片、分享突出显示
	$('.each_publisher_type_name').click(function () {
		$(this).parent().addClass('current').siblings().removeClass('current');
	})
	
	$('.insert_comment_text').focus(function () {
		$(this).animate({height:'30px'});
		$(this).siblings('.insert_comment_button').show();
		$(this).parent().siblings('.comment_biaoqing').show();
	})
	
//	$('.insert_comment_text').blur(function () {
//		$(this).animate({height:'20px'});
//		$(this).siblings('.insert_comment_button').hide();
//	})

	$('.comment_biaoqing').click(function () {
		var newThis = $(this).siblings('.comment_biaoqing_float_box');
		var thisCondition = newThis.attr('title');
		if (thisCondition == 'hide')
		{
			newThis.attr('title','show').show();
		}
		else
		{
			newThis.attr('title','hide').hide();
		}
	})
	
	$('.comment_biaoqing_icon img').click(function () {
		var thisAlt = $(this).attr('alt');
		var newThis = $(this).parent().parent().parent().siblings('form').children('.insert_comment_text');
		var newTextContent = newThis.val();
		newThis.attr('value',newTextContent+thisAlt);
		$(this).parent().parent().parent('.comment_biaoqing_float_box').attr('title','hide').hide();
	})
	
//	$('#publisher_input').focus(function () {
//		$(this).animate({height:'70px'});
//		$("#publisher").animate({height:'160px'});
//		$("#publisher_biaoqing").show();
//		$("#publisher_button").show();
//	})
})

	$('#publisher_biaoqing').click(function () {
		var thisCondition = $('#biaoqing_float_box').attr('title');
		if (thisCondition == 'hide')
		{
			$('#biaoqing_float_box').attr('title','show').show();
		}
		else
		{
			$('#biaoqing_float_box').attr('title','hide').hide();
		}
	})
	
	$('.biaoqing_icon img').click(function () {
		var thisAlt = $(this).attr('alt');
		var nowTextContent = $('#publisher_input').val();
		$('#publisher_input').attr('value',nowTextContent+thisAlt);
		$('#biaoqing_float_box').attr('title','hide').hide();
	})
	
	$('.close_comment').click(function () {
		var thisCondition = $(this).html();
		if (thisCondition == '收起')
		{
			$(this).parent().siblings('.news_comment_box').children('.news_comment_area').hide('200');
			$(this).html('展开');
		}
		else
		{
			$(this).parent().siblings('.news_comment_box').children('.news_comment_area').show('200');
			$(this).html('收起');
		}
		
	})
	
	
	