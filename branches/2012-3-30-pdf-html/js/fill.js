var toolboxData = {};

var timer = 1;

var toolbarTpl = {
	'common': function(){
		return '<div class="toolbox active" >'
		+'<span class="movePanel"></span>'
		+'<div class="toolPanel hide">'
		+'<span class="confirm">ok</span>'
		+'<span class="delete">delete</span>'
		+'</div>'
		+'<div class="editPanel hide"><span>edit</span></div>'
		+'</div>';
	},
	'textbox': function(obj){
		return '<input type="text" maxlength="' + obj.num + '" style="font-size:'+ obj.fontSize +'px"/>';
	},
	'textarea': function(obj){
		return '<textarea name="" id="" cols="'+ obj.col +'" rows="'+ obj.row +'" style="font-size:'+ obj.fontSize +'px"></textarea>';
	},
	'checkbox': function(obj){
		return '<input type="checkbox" data-boxSize="'+ obj.size +'"/>';
	},
	'radio': function(obj){
		return '<input type="radio" data-boxSize="'+ obj.size +'"/>';
	},
	'signature': function(obj){
		return '<div class="signbox form">'
	  +'<span class="clicktosign">Sign</span>'
	  +'<div class="sign hide">'
	  +'<h4>Please draw your signature!</h4>'
	  +'<div class="signature"></div>'
	  +'<div class="loadingbar hide"><img src="images/loading.gif" alt=""></div>'
	  +'<div class="signtools">'
	  +'<span class="signok">OK</span>'
	  +'<span class="signclear">Clear</span>'
	  +'<span class="signcancel">Cancel</span>'
	  +'</div>'
		+'</div>'
		+'</div>'
	}
};

// fillToolsTpl
var fillToolsTpl = {
	'textbox': function(){
		return '<div class="fillToolsMenu">'
		+'<label>Max-length:</label>'
		+'<input type="text" data-kind="num" value="10"/><br/>'
		+'<label>font-size:</label>'
		+'<input type="text" data-kind="fontSize" value="14"/><br/>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'textarea': function(){
		return '<div class="fillToolsMenu">'
		+'<label>Rows:</label>'
		+'<input type="text" data-kind="row" value="10"/><br/>'
		+'<label>Cols:</label>'
		+'<input type="text" data-kind="col" value="60"/><br/>'
		+'<label>font-size:</label>'
		+'<input type="text" data-kind="fontSize" value="14"/><br/>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'checkbox': function(){
		return '<div class="fillToolsMenu">'
		+'<input type="radio" data-kind="size" name="checkbox" value="small" /><br/>'
		+'<input type="radio" data-kind="size" name="checkbox" value="mid" /><br/>'
		+'<input type="radio" data-kind="size" name="checkbox" value="large" /><br/>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'radio': function(){
		return '<div class="fillToolsMenu">'
		+'<input type="radio" data-kind="size" name="radio" value="small" /><br/>'
		+'<input type="radio" data-kind="size" name="radio" value="mid" /><br/>'
		+'<input type="radio" data-kind="size" name="radio" value="large" /><br/>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'signature': function(){
		return '<div class="fillToolsMenu">'
		+'<label>Width:</label>'
		+'<input type="text" data-kind="width" value="620"/><br/>'
		+'<label>Height:</label>'
		+'<input type="text" data-kind="heigclass" value="150"/><br/>'
		+'<span class="addTool">Add</span>'
		+'</div>';''
	}
};

var Toolbar = function(obj){
	this.name = 'toolbox'+timer;
	this.options = $.extend({
		'type': 'textbox',
		'num': 10,
		'fontSize': '14px',
		'size': 'mid',
		'row': 30,
		'col': 10,
		'width': 620,
		'height': 150,
		'offset': 0
	}, obj);

	this.render();
	if(this.options.type === 'signature'){
		$('body').trigger('addSignature');
		$(".signature").jSignature({
			width: this.options.width,
			height: this.options.height,
			lineWidth: 3
		});
	}
	timer++;
};

Toolbar.prototype = {
	render: function(){
		var self = this,
				toolbox = $(toolbarTpl['common']()),
				api = $('#pdf').jScrollPane().data('jsp'),
				barHeight = parseInt($('#pdf .jspDrag').css('top'));

		self.scrollHeight = api.getPercentScrolledY() * api.getContentHeight() - barHeight;
		self.el = $(toolbarTpl[self.options.type](self.options));

		// console.log(toolbox);
		toolbox
			.appendTo('#pdfbox')
			.draggable({
				drag: function(){
					$(this).find('.toolPanel').hide();
				},
				stop: function(){
					$(this).find('.toolPanel').show();
					self.options.offset = self.el.offset();
				}
			})
			.find('.delete')
				.bind('click', function(){
					$(this).parents('.toolbox').detach();
				})
				.end()
			.find('.confirm')
				.bind('click', function(){
					$(this).parent().hide();
					$(this).parents('.toolbox').draggable('disable').removeClass('active');
					toolboxData[self.name] = self.options;
				})
				.end()
			.find('.editPanel')
				.bind('click', function(){
					$(this).parents('.toolbox').find('.toolPanel').show();
					$(this).parents('.toolbox').addClass('active').draggable('enable');
					$(this).hide();
				})
				.end()
			.prepend(self.el)
			.css({'position': 'absolute', 'top': self.scrollHeight});
	}
};