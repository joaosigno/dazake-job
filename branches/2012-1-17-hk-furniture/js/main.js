$(function () {
//************************main*************************

//********************plugins*******************************
//bc-slide.js
	var i = 1,
		j = 0,
		next = 0;
		
	function slide(target){
		switch (j) {
			case 0:
				next = 1;
			break;
			case 1:
				next = 2;
			break;
			case 2:
				next = 0;
			break;
		}
		var newThis = $("#"+target);
		newThis.children("a:eq("+j+")").children("img").fadeOut(700);
		newThis.children("a:eq("+next+")").children("img").fadeIn(700);
	}

	function test() {
		slide("slideshow"+i);
		if(i == 3){
			j++;
			if(j == 3){
				j = 0;
			}
			i = 0;
		}
		i++;
	}
	
	if($('#main img').length == 9){
		var t = setInterval(test, 1650);
	
		$(".slideshow").mouseover(function () {
			clearInterval(t);
		})
		
		$(".slideshow").mouseout(function () {
			t = setInterval(test, 1650);
		})
	}

//scroll.js
$(function () {
	var imgWith = 332,
		totalWith = $('#showbox img').length*(1+imgWith),
		pace = (imgWith+1),
		maxScroll = totalWith-1000;
	if($('#showbox img').length > 3){
		$('#showbox').css({'width':totalWith,'margin-left':-999});
	}
	function goScroll(direct){
		var stringNowPos =$('#showbox').css('margin-left'),
			nowPos = Number(stringNowPos.replace(/px/,''));
		switch(direct){
			case 'nav_left':
				if(nowPos != 0){$('#showbox').animate({'margin-left':nowPos+pace});}
				break;
			case 'nav_right':
				if(nowPos != -1998){$('#showbox').animate({'margin-left':nowPos-pace});}
				break;
			defautl:
				return false;
				break;
		}
	}
	$('.scroll_nav').click(function(){
		var self = $(this);
		goScroll(self.attr('id'));
	});
})

//********************about.php*************************
	
//	item click action
	$(function(){
		$('#about .item').click(function(){
			$(this).addClass('active').siblings('.item').removeClass('active');
		})
	})
//********************collection.php*************************	
		
	//show the nav_button
		$("#collection").mouseover(function () {
			$("#show_nav").show();
		})
		
		$("#collection").mouseout(function () {
			$("#show_nav").hide();
		})
})

//********************designer.php*************************
$(function(){
	$('#designer-items>.cat-item>a').removeAttr('href').on('click',function(){
		$(this).parent('.cat-item').siblings('.cat-item').children('ul').slideUp();
		$(this).siblings('ul').slideDown();
	});
})

//********************single-product.php*************************
$(function(){
	var oriImg = $('#pro_show img').attr('src'),
		k;
    $('.imgcover').mouseover(function(){
  		$('#pro_show img').attr('src',$(this).siblings('img').attr('src'));
        clearTimeout(k);
    })

    $('.imgcover').mouseout(function(){
    	k = setTimeout(function(){
    		$('#pro_show img').attr('src',oriImg);
    	},500);
	})
});
//********************project.php*************************
$(function(){
	var midImgUrl = $('#midbox img').attr('src'),
		t;
	$('.project_item').mouseover(function(){
		$('#project_preview img').attr('src',$(this).attr('id')).fadeIn();		
	});

	$('.project_item').mouseout(function(){
		$('#project_preview img').hide();		
	});

	$('#project_display img').mouseover(function(){
		$('#midbox img').attr('src',$(this).attr('src'));
		clearTimeout(t);
	});

	$('#project_display img').mouseout(function(){
			t = setTimeout(function(){
			$('#midbox img').attr('src',midImgUrl);
		},500);
	});
})	
	
//********************temp*************************

// $(function(){
// 	$('#menu a').click(function(e){
// 		e.preventDefault();

// 		console.log('ddd');
// 	})

// });
