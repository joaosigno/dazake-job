
//Scripts for about.php to load content using ajax
//Author:Bryant

var URL = $('#items').data('save'),//URL to the admin-ajax.php
	statue = 0,					   //check whether all the ajax-request are ok or not
	latestClick = 0,			   //record which item was just been clicked
	defaultNum = 3,
	objItem = [];				   //Objects for items

//to assign each item an object 
for(var i = 1; i<= $('.item').length; i++){
	var $this = $('.item:eq('+i+')');
	objItem[i] = {
		name : $this.attr('id'),
		type : $this.data('type'),
		content : ['0'],
		index : i
	}
}

//add content to $('#rightbox2')
function addContent(index){
	if(latestClick == 0){
		return false;  //if no item was clicked,return false
	}else{
		var type = $('.item:eq('+index+')').data('type'), //get the item type
			container = objItem[index].content,
			$rightbox2 = $('#rightbox2');	

		switch(type){
			//add content if the item type is 'single'
			case 'single':
				$rightbox2.empty().show().append(container[0]);
				break;
			//add content if the item type is 'cate'
			case 'cate':
				$rightbox2.empty();
				// container.length
				var	PostNum = (defaultNum > container.length) ? container.length : defaultNum;
				for(var i = 0; i <= PostNum-1; i++){
					$rightbox2.attr('title',index).append("<div class='each_post'>"+container[i]+"</div>");
				}
				if(defaultNum < container.length){
					$rightbox2.append("<div class='showMore'>More</div>");
				}
				$rightbox2.show();
				break;

			default:
				return false;
				break;
		}
	}
}

//show more than default post numbers
function showMore(postNum){
	var $this = $(this),
		index = $('#rightbox2').attr('title'),
	    maxNum = objItem[index].content.length,
	    afterNum = postNum + defaultNum,
	    addNum = (afterNum > maxNum) ? maxNum : afterNum;
	
	for(var i = postNum; i < addNum; i++){
		$('#rightbox2').scrollTop($('#rightbox2').scrollTop()+300);
		$("<div class='each_post' style='display:none;'>"+objItem[index].content[i]+"</div>").insertBefore('.showMore').fadeIn(1000);
	}
	if($('#rightbox2').children('.each_post').length == maxNum){
		$('.showMore').hide();
	}
}

//get content via ajax and store them
function getContent(obj){
	$.ajax({
		type:"POST",
		url:URL,
		data:{sendData:obj,action:'implement_ajax'},
		beforeSubmit:function () {},
		success:function (data) {
			//cache data in an array if item type is 'cate'
			if(obj.type == 'cate'){
				var dataString = data.split('@');
				for(var i = 0; i < dataString.length-1; i++){
					objItem[obj.index].content[i] = dataString[i];
				}
			}else{
			//cahce data in the first array of content[] if item type is 'single'
				objItem[obj.index].content[0] = data;
			}
			//use the global variables to check whether all the ajax request were finished
			statue++;
			if(statue == 5){
				//if ajax request were finished,then hide the waitingbox
				$('#waitingbox').fadeOut();
				//after hiding the waitingbox,go back to the previous item-display-board
				addContent(latestClick);
			}
		}
	});
}

$(document).ready(function(){
	// on loaded, send ajax request to get the content
	for(var i = 1; i <= $('.item').length; i++){
		getContent(objItem[i]);
	}

	//when click on the '.mainitem',hide the '#rightbox2' and display the default page
	$('.mainitem').click(function(){
		$('#rightbox2').hide();
	});
	
	$('.subitem').click(function(){
		if(statue == 5){
			latestClick = $(this).index();
			addContent($(this).index());
		}else{
			latestClick = $(this).index();
			$('#waitingbox').fadeIn();
		}
	});

	$('#rightbox2').on('click','.showMore',function(){
		var arg = $(this).siblings('.each_post').length;
		showMore(arg);
	});
});