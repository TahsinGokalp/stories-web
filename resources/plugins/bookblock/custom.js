var sound = null;
function playSound(page){
    if(sound !== null){
        sound.stop();
    }
    if (page in soundFiles){
        sound = new Howl({
            src: [soundFiles[page]],
            html5: true
        });
        sound.play();
    }
}
function loadPage(page){
    let img = $("#book-page-"+(page+1));
    if(img.hasClass("lazy")){
        let src = img.attr("data-src");
        img.attr("src", src).removeAttr("data-src").removeClass("lazy");
    }
}
var Page = (function() {
    var config = {
            $bookBlock : $( '#bb-bookblock' ),
            $navNext : $( '#bb-nav-next' ),
            $navPrev : $( '#bb-nav-prev' ),
            $navFirst : $( '#bb-nav-first' ),
            $navLast : $( '#bb-nav-last' )
        },
        init = function() {
            config.$bookBlock.bookblock( {
                orientation : 'vertical',
                direction : 'ltr',
                speed		: 1000,
                easing		: 'ease-in-out',
                shadows		: true,
                shadowSides	: 0.2,
                shadowFlip	: 0.1,
                circular	: false,
                autoplay        : false,
                onEndFlip	: function( old, page, isLimit ) {
                    loadPage(page);
                    loadPage(page+1)
                    playSound(page+1);
                    return false;
                },
            } );
            initEvents();
        },
        initEvents = function() {

            var $slides = config.$bookBlock.children();

            // add navigation events
            config.$navNext.on( 'click touchstart', function() {
                config.$bookBlock.bookblock( 'next' );
                return false;
            } );

            config.$navPrev.on( 'click touchstart', function() {
                config.$bookBlock.bookblock( 'prev' );
                return false;
            } );

            config.$navFirst.on( 'click touchstart', function() {
                config.$bookBlock.bookblock( 'first' );
                return false;
            } );

            config.$navLast.on( 'click touchstart', function() {
                config.$bookBlock.bookblock( 'last' );
                return false;
            } );
            // add swipe events
            $slides.on( {
                'swipeleft' : function( event ) {
                    config.$bookBlock.bookblock( 'next' );
                    return false;
                },
                'swiperight' : function( event ) {
                    config.$bookBlock.bookblock( 'prev' );
                    return false;
                }
            } );
            // add keyboard events
            $( document ).keydown( function(e) {
                var keyCode = e.keyCode || e.which,
                    arrow = {
                        left : 37,
                        up : 38,
                        right : 39,
                        down : 40
                    };

                switch (keyCode) {
                    case arrow.left:
                        config.$bookBlock.bookblock( 'prev' );
                        break;
                    case arrow.right:
                        config.$bookBlock.bookblock( 'next' );
                        break;
                }
            } );
        };
    return { init : init };
})();
Page.init();
