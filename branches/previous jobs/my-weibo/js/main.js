var ajaxUrl = "./modular/chuli.php";
var comment = new Array();
//*****floatbox***** 
		
		//触发弹出事件
		$('.float_trigger').click(function () {
			if($(this).siblings(".float_box").is(":visible"))
			{
				$(this).siblings(".float_box").hide();
			}
			else 
			{
				$(this).parent().siblings().children('.float_box').hide();
				var newThis = $(this).siblings('.float_box');
				newThis.show();
				newThis.children('.float_input_text').attr('value','');
			}
		});
		
		
		//关闭弹出窗口
		$('.float_cancel').click(function () {
			$(this).parent('.float_box').hide();
		});
		
		
		//将输入的地址加到图片和视频的input中
		$('.float_send').click(function () {
			var newThis = $(this);
			var newType = newThis.attr('name');
			$('#'+newType).attr('value',newThis.parent().children('.float_input_text').attr('value'));
			$('#float_msn').show().html('成功上传！').fadeOut(2000);
			newThis.parent('.float_box').hide();
		});
		
		//计算剩余字数
		function countLeft(leftNumber) {
			var leftNumber;
			document.getElementById("input_left_number").innerHTML=(140-leftNumber.length);
			//验证是否有输入，否则按钮是灰色
			var inputContent = $('#input_text').attr('value');
			if( inputContent == "")
			{
				$('#send_button').removeClass('send_button');
			}
			else
			{
				$('#send_button').addClass('send_button');
			}
		}
		
		//输入表情 
		$('.biaoqing_img img').click(function(){
			var thisOne = $(this).parent().parent();
			var biaoqing = $(this).attr('alt');
			var nowContent = $('#input_text').attr('value');
			if(nowContent != "")
			{
				$('#input_text').attr('value',nowContent+biaoqing);
				thisOne.parent('.float_box').hide();
			}
			else
			{
				$('#input_text').attr('value',biaoqing);
				thisOne.parent('.float_box').hide();	
			}
		})
		
		
		//发送内容判断
		$('#send_button').click(function () {
			var herefff = $('#input_text').attr('value');
			if(herefff == '')
			{
				alert('请输入内容');
				return false;
			}
		})		