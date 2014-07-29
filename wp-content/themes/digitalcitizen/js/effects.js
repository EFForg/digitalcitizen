jQuery(function($){
    var previousScroll = $(this).scrollTop(),
        masthead = $('#masthead'),
        up = false,
        down = false;

    $(window).scroll(function () {
        var currentScroll = $(this).scrollTop();
        if (currentScroll > previousScroll && !down) {
            masthead.removeClass('down').addClass('up');
            down = true;
            up = false;
            return true;
        }
        if  (currentScroll < previousScroll && !up) {
            masthead.removeClass('up').addClass('down');
            up = true;
            down = false;
        }
        previousScroll = currentScroll;
    });
});


