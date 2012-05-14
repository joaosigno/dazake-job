


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
			url: "test/test.php" #this is the url to the edit.php
			data:
				action: 'statusupdate'
				id: @id
				status: @status

	##main javscript use##
	getContainerWidth '.dk-container-in'

	bookId = 0
	status = ""

	$('.dk-category')
		.sortable
			items: '.dk-book'
			revert: true
			connectWith: '.dk-category'
			receive: (evt, ui) ->
				$el = $(evt.target)
				$container = $el.find('.dk-container-in')
				$width = $container.width()
				status = $el.data('status')
				$container.css
					width: $width + 120
			stop: (evt, ui) ->
				bookId = ui.item.data('id')

				syncData(bookId, status)


