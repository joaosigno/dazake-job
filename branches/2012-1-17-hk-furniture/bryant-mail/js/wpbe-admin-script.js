jQuery(document).ready(function($){

	// Send email preview
	$('#wpbe_send_preview').click(function(e) {
		e.preventDefault();
		var $mails = $('#maillist').find('input[checked="checked"]');
		var mails = [];
		for(var i=0; i<$mails.length; i++){
			mails[i] = $mails[i]['value'];
		}
		// var email = $('#wpbe_email_preview_field').val(), message = $('#wpbe_preview_message'), loading = $('#wpbe_ajax_loading');
		var email = mails, message = $('#wpbe_preview_message'), loading = $('#wpbe_ajax_loading');
		$.ajax({
			type: 'post',
			url: wpbe_ajax_vars.url,
			data: {
				action: wpbe_ajax_vars.action,
				preview_email: email,
				_ajax_nonce: wpbe_ajax_vars.nonce
			},
			beforeSend: function() {
				loading.css('visibility', 'visible');
			},
			complete: function() {
				loading.css('visibility', 'hidden');
			},
			success: function(data) {
				message.append(data).fadeOut(3000);
			}
		});
	});
	
	// Trigger help
	$('#wpbe_help').bind('click', function(e){
		e.preventDefault();
		$('a#contextual-help-link').trigger('click');
	});
    
	// Thickbox preview
	$('#wpbe_preview_template').live('click', function(e) {
		e.preventDefault();
		var preview_iframe = $('#TB_iframeContent');
		if( preview_iframe.length ) {
			var template;
			if (typeof(tinyMCE) != 'undefined') {
				if( tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden() )
					template = tinyMCE.activeEditor.getContent();
				else
					template = $('.wpbe_template').val();
			}
			preview_iframe = preview_iframe[preview_iframe.length - 1].contentWindow || frame[preview_iframe.length - 1];
			preview_iframe.document.open();
			preview_iframe.document.write( template );
			preview_iframe.document.close();
		}
	});


	//bryant
	$('#ztem-user-group').change(function(){
		console.log($(this).val());
		var selectGroup = $(this).val();
		$('#maillist input.radio').removeAttr('checked');
		$('#maillist input.'+selectGroup).attr('checked', 'checked');
	});

	$('.radio').click(function(){
		var value = $(this).attr('checked');
		console.log(value);
		if(value === undefined ){
			$(this).removeAttr('checked');
		}else{
			$(this).attr('checked', 'checked' );
			
		}
		
	});
});
