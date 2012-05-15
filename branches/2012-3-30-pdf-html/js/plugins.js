// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());


// place any jQuery/helper plugins in here, instead of separate, slower script files.
	var PDF = function(id, picPath){
		console.log(this);
		this.id = id;
		// this.path = (picPath)? picPath : '';
		this.path = (picPath)? "<img id='draggablepic' src='images/"+picPath+"' />": undefined;
		this.container = $("#pdfbox");
		this.init();
	};

	PDF.prototype.init = function(){
		that = this;
		$('.addOn-active').detach();
		this.addEl();
	};

	PDF.prototype.els = {
		"textbox" : "<input type='text'>",
		"checkbox": "<input type='checkbox'>",
		"radio": "<input type='radio'>"
		// "signok": "<img id='draggablepic' src='images/"+this.path+"' />"
		// "signok": this.path
	};

	PDF.prototype.addEl = function(){
		that = this;
		var wrapper = (this.path)? this.path : this.els[this.id];
		// console.log(wrapper);
		this.container.prepend("<div class='draggable addOn-active'>"+wrapper+"</div>");
		$('.addOn-active').css('top',$('#pdf').scrollTop());
		$('.addOn-active').draggable({
			containment: 'window',

			start: function(){
				$('.detachable').detach();
			},

			stop: function(){
				$(".addOn-active").prepend("<div id='infobox' class='detachable'><span class='confirm'>OK</span><span class='delete'>Delete</span></div><div id='triangel'  class='detachable'></div>")
			}
		});
	};

	PDF.prototype.confirmEl = function(){
		$(".addOn-active").removeClass("addOn-active").addClass("addOn-fixed").draggable('disable');
		$(".addOn-active").resizable();
		$(".detachable").detach();
	};

	PDF.prototype.removeEl = function(){
		$(".addOn-active").detach();
	};