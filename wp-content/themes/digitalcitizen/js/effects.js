jQuery(function($){
    var previousScroll = $(this).scrollTop(),
        masthead = $('#masthead'),
        up = false,
        down = false;

    $(window).scroll(function () {
        var currentScroll = $(this).scrollTop();
        if (currentScroll > ($(window).height()/4) ) {
            if (currentScroll > previousScroll && !down) {
                lastDelta = currentScroll;
                masthead.removeClass('down').addClass('up');
                down = true;
                up = false;
                return true;
            }
            if  (currentScroll < previousScroll && !up) {
                lastDelta = currentScroll;
                masthead.removeClass('up').addClass('down');
                up = true;
                down = false;
            }
        }
        previousScroll = currentScroll;
    });

    $('body').scrollspy({ target: '#toc_container' });

    $(window).load(function(){
        var toc_offset = $(".toc_widget").offset();
        $(".toc_widget").affix({
            offset: {
                top:toc_offset.top - 168,
                bottom:500
            }
        }).on('affix.bs.affix',function(e){ console.log(e) });
    });
});


