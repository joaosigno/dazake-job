var toolboxData = {};

var timer = 1;

var toolbarTpl = {
	'common': function(){
		return '<div class="toolbox active" >'
		+'<div class="toolPanel">'
		+'<span class="confirm">ok</span>'
		+'<span class="delete">delete</span>'
		+'</div></div>';
	},
	'textbox': function(obj){
		return '<input type="text" maxlength=' + obj.num + ' style="font-size:'+ obj.fontSize +'"/>';
	},
	'textarea': function(obj){
		return '<textarea name="" id="" cols="'+ obj.col +'" rows="'+ obj.row +'" style="font-size:'+ obj.fontSize +'"></textarea>';
	},
	'checkbox': function(obj){
		return '<input type="checkbox" data-boxSize="'+ obj.size +'"/>';
	},
	'radio': function(obj){
		return '<input type="radio" data-boxSize="'+ obj.size +'"/>';
	},
	'signature': function(obj){

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
		'width': 0,
		'height': 0,
		'offset': 0
	}, obj);

	console.log(this.options);
	this.render();
	timer++;
};

Toolbar.prototype = {
	render: function(){
		var self = this,
				toolbox = $(toolbarTpl['common']());

		self.el = $(toolbarTpl[self.options.type](self.options));
		// console.log(toolbox);
		toolbox
			.appendTo('#pdfbox')
			.draggable({
				stop: function(){
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
					toolboxData[self.name] = self.options;
				})
				.end()
			.prepend(self.el);
	}
};

// fillToolsTpl
var fillToolsTpl = {
	'textbox': function(){
		return '<div class="fillToolsMenu hide">'
		+'<label>Max-length:</label>'
		+'<input type="text" data-kind="num"/>'
		+'<label>font-size:</label>'
		+'<input type="text" data-kind="fontSize"/>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'textarea': function(){
		return '<div class="fillToolsMenu hide">'
		+'<label>Rows:</label>'
		+'<input type="text" data-kind="row"/>'
		+'<label>Cols:</label>'
		+'<input type="text" data-kind="col"/>'
		+'<label>font-size:</label>'
		+'<input type="text" data-kind="fontSize"/>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'checkbox': function(){
		return '<div class="fillToolsMenu hide">'
		+'<ul>'
		+'<li>'
		+'<span>1.</span>'
		+'<span>small</span>'
		+'</li>'
		+'<li>'
		+'<span>2.</span>'
		+'<span>mid</span>'
		+'</li>'
		+'<li>'
		+'<span>3.</span>'
		+'<span>large</span>'
		+'</li>'
		+'</ul>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'radio': function(){
		return '<div class="fillToolsMenu hide">'
		+'<ul>'
		+'<li>'
		+'<span>1.</span>'
		+'<span>small</span>'
		+'</li>'
		+'<li>'
		+'<span>2.</span>'
		+'<span>mid</span>'
		+'</li>'
		+'<li>'
		+'<span>3.</span>'
		+'<span>large</span>'
		+'</li>'
		+'</ul>'
		+'<span class="addTool">Add</span>'
		+'</div>';
	},
	'signature': function(){

	}
}

$(function(){
	$('.fillTools span.test').click(function(){
		if(!$(this).hasClass('addMenu')){
			var thisType = $(this).data('type'),
					thisTpl = fillToolsTpl[thisType]();
			$(this).after(thisTpl).addClass('addMenu');
		}else{
			$(this).siblings('.fillToolsMenu').toggle();
		}
	});

	$('.fillTools').on('click', '.addTool', function(){
		var $parent = $(this).parents('.fillToolsMenu'),
				arg = {};
		for (var i = 0; i < $parent.children('input').length; i++){
			var thisInput = $($parent.children('input')[i]);
			arg[thisInput.data('kind')] = thisInput.val();
		}
		new Toolbar(arg);
	});
})