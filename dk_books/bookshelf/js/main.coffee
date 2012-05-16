$ ->
	##public functions##
	k = (o) ->
		console.log o

	#resize the container width
	getContainerWidth = (container) ->
		container = container

		$(container).each ->

			$books = $(@).find '.dk-book'

			booksNum = $books.length;
			bookWidth = $books.width() + parseInt($books.css 'margin')*2

			$(@).css
				width: bookWidth*booksNum

	#sync data
	syncData = (id, status) ->
		@id = id
		@status = status
		k @id
		k @status

		$.ajax
			type: "POST"
			url: $('#dk-bookshelf').data('url') #this is the url to the edit.php
			data:
				action: 'statusupdate'
				id: @id
				status: @status

	##main javscript use##
	getContainerWidth '.dk-container-in'

	bookId = 0
	status = ""

	dkTimer = (fn) ->
		@fn = fn
		t = setTimeout( -> 
			@fn()
		, 1000)

	sortOpts = 
		items: '.dk-book'
		opacity: ".7"
		revert: true
		placeholder: "dk-empty dk-book"
		forcePlaceholderSize: true
		connectWith: '.dk-category'
		start: (evt, ui) ->
			$el = $(evt.target)
			$el.siblings('.dk-category').find('.dk-hide').hide()

		receive: (evt, ui) ->
			$el = $(evt.target).find('.dk-container-in')
			status = $(evt.target).data('status')
			$width = $el.width()
			$el.css
				width: $width + 100
			$item  = ui.item
			$item.appendTo($el)
			syncData(bookId, status)

		remove: (evt, ui) ->
			$el = $(evt.target).find('.dk-container-in')
			$width = $el.width()
			$el.css
				width: $width - 100

		stop: (evt, ui) ->
			bookId = ui.item.data('id')
			
		over: (evt, ui) ->
			dkTimer ->
				$el = $(evt.target).find('.dk-title')
				$el.siblings('.dk-container-out').slideDown()

	$('.dk-category')
		.sortable sortOpts

	#toggle the bookcontainer
	$('.dk-switch').click ->
		$(@)
			.parent()
			.siblings('.dk-container-out')
			.slideToggle()


