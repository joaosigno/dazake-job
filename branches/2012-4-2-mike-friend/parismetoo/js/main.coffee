
#main script

k = (o) ->
	# console.log(o)

$ ->

	$('.qqcontact').tooltip();

	# /iehack for img hover to display opacity effect
	$('.no-opacity .cover img')
		.bind 'mouseover', ->
			$(@).css 
				'opacity': '0.5'
		.bind 'mouseout', ->
			$(@).css 
				'opacity': '1'