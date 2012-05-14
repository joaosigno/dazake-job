// Generated by CoffeeScript 1.3.1
(function() {

  $(function() {
    var bookId, getContainerWidth, k, status, syncData;
    k = function(o) {
      return console.log(o);
    };
    getContainerWidth = function(container) {
      container = container;
      return $(container).each(function() {
        var $books, bookWidth, booksNum;
        $books = $(this).find('.dk-book');
        booksNum = $books.length;
        bookWidth = $books.width() + parseInt($books.css('margin')) * 2;
        return $(this).css({
          width: bookWidth * booksNum
        });
      });
    };
    syncData = function(id, status) {
      this.id = id;
      this.status = status;
      k(this.id);
      k(this.status);
      return $.ajax({
        type: "POST",
        url: "test/test.php",
        data: {
          action: 'statusupdate',
          id: this.id,
          status: this.status
        }
      });
    };
    getContainerWidth('.dk-container-in');
    bookId = 0;
    status = "";
    return $('.dk-category').sortable({
      items: '.dk-book',
      revert: true,
      connectWith: '.dk-category',
      receive: function(evt, ui) {
        var $container, $el, $width;
        $el = $(evt.target);
        $container = $el.find('.dk-container-in');
        $width = $container.width();
        status = $el.data('status');
        return $container.css({
          width: $width + 120
        });
      },
      stop: function(evt, ui) {
        bookId = ui.item.data('id');
        return syncData(bookId, status);
      }
    });
  });

}).call(this);
