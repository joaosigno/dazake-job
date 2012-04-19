/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options=$.extend({},options);options.expires=-1;}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000));}else{date=options.expires;}expires='; expires='+date.toUTCString();}var path=options.path?'; path='+(options.path):'';var domain=options.domain?'; domain='+(options.domain):'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('');}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break;}}}return cookieValue;}};
/**
 * Display Griding
 *
 * Copyright (c) 2011 Jc Pack & Bob Green (places-finder.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.noConflict();
(function($){$(function(){if($.cookie('mode')=='grid'){grid_update();}else if($.cookie('mode')=='list'){list_update();} $('#mode').toggle(function(){if($.cookie('mode')=='grid'){$.cookie('mode','list');list();}else{$.cookie('mode','grid');grid();}},function(){if($.cookie('mode')=='list'){$.cookie('mode','grid');grid();}else{$.cookie('mode','list');list();}});function grid(){$('#mode').addClass('flip');$('#loop').hide('fast',function(){grid_update();$(this).show("fast");});} function list(){$('#mode').removeClass('flip');$('#loop').hide('fast',function(){list_update();$(this).show("fast");});} function grid_update(){$('#loop').addClass('grid').removeClass('list');$.cookie('mode','grid');} function list_update(){$('#loop').addClass('list').removeClass('grid');$.cookie('mode','list');}})})(jQuery) 