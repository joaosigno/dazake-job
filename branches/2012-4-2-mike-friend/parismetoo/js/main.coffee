
#main script

k = (o) ->
	console.log(o)

$ ->

	$('.qqcontact').tooltip();

	#iehack for img hover to display opacity effect
	$('.no-opacity .cover img')
		.bind 'mouseover', ->
			$(@).css 
				'opacity': '0.5'
		.bind 'mouseout', ->
			$(@).css 
				'opacity': '1'

	#pie iehack
	ieHack = (el) ->
		if(window.PIE)
		then $(el).each ->
			PIE.attach(@)

	ieHack '.cover'
	ieHack 'img'
	ieHack '#qqcontact'
	ieHack '.eachPackage'
	ieHack '#about-us'
	ieHack '#contactDetail'

	#menu hover change background
	menuContent = 
		'home': '首页'
		'about': '关于'
		'works': '作品'
		'price': '价格'
		'flow': '流程'
		'gallery': '风情赏'
		'contact': '联系'

	$('#menu li a').each ->
		temp = ''
		$(@).mouseover ->
			temp = $(@).text().toLowerCase()
			$(@).text(menuContent[temp])
			pos = parseInt $('#pic'+temp).css 'background-position-y'
			$('#pic'+temp).css
				'background-position-y': pos+90

		$(@).mouseout ->
			$(@).text(temp)
			pos = parseInt $('#pic'+temp).css 'background-position-y'
			$('#pic'+temp).css
				'background-position-y': pos-90

	$('.eachPackage').click ->
		showItem = parseInt $(@).data 'slide'
		$('#slideContent').animate
			'margin-left': showItem
		
		







