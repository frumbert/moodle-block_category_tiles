define(['jquery'], function($) {
    var t = {
        init: function() {
            t.startListening();
            t.resize();
        },
        resize: function() {
            var block = $('.block_category_tiles');
            var tiles = $('.block_category_tiles li');
            var blockWidth = $(block).width();
            if (blockWidth >= 1050) {
                $(tiles).removeClass('col1 col2 col3');
                $(tiles).addClass('col4');
            } else if (blockWidth < 400) {
                $(tiles).removeClass('col2 col3 col4');
                $(tiles).addClass('col1');
            } else if (blockWidth < 750) {
                $(tiles).removeClass('col1 col3 col4');
                $(tiles).addClass('col2');
            } else if (blockWidth < 1050) {
                $(tiles).removeClass('col1 col2 col4');
                $(tiles).addClass('col3');
            }
        },
        startListening: function() {
            $(window).resize(function() {
                t.resize();
            });
        }
    };
    return t;
});
