window.viewportUnitsBuggyfill.init({hacks:viewportUnitsBuggyfillHacks});

jQuery(function($){
    var previousScroll = $(this).scrollTop(),
        masthead = $('#masthead'),
        up = false,
        down = false,
        currentScroll,
        direction,
        previousDirection;

    $(window).scroll(function(e) {
        //Cache current scroll location
        currentScroll = $(this).scrollTop();
        
        //Are we going up or down?
        direction = currentScroll > previousScroll ? 'down' : 'up';

        //Did the direction change?
        if(direction != previousDirection) {
            nav_toggle_listener(direction, currentScroll);
        }
       
        previousScroll = currentScroll;
        previousDirection = direction;
    });

    function nav_toggle_listener(direction, start_position) {
        //Remove any existing listener
        $(window).off('scroll.nav_listener');
        //Reset scroll counter
        var start_position = start_position;
        console.log(start_position);
        //Make our direction available to the anonymous function running on scroll
        var direction = direction;

        $(window).on('scroll.nav_listener',function(e){
            if( Math.abs($(this).scrollTop() - start_position) > 200 ) {
                //do the thing
                toggle_header(direction);
                //kill the listener
                $(window).off('scroll.nav_listener');
            }
        });
    }

    function toggle_header(direction) {
        if(direction == 'down') {
            masthead.removeClass('down').addClass('up');
        } else {
            masthead.removeClass('up').addClass('down');
        }
    }

    $(window).load(function(){
        if( $(window).width() >= 1000 ) {
            var toc_offset = $(".toc_widget").offset();
            $(".toc_widget, #social-bar").affix({
                offset: {
                    top:toc_offset.top - 147,
                    bottom:500
                }
            });
        }
    });
});


