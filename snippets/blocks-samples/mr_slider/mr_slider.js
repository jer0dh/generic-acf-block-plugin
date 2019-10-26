(function ($) {


    /**
     * initializeBlock
     *
     * Adds custom JavaScript to the block HTML.
     * 
     * Swiper js and css loaded via acf_register_block
     * 
     * @date    15/4/19
     * @since   1.0.0
     *
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */


    const initializeBlock = function ($block) {
        console.log('initializeBlock-mr-slider');
        // load responsive background images

        const $mrSlider = $block.find( '.swiper-container' );
        const mySwiper = new Swiper( $mrSlider, {
            speed: 2000
        });
        const $mrSlideClicker = $block.find('.mr-slide-clicker');
        const $mrClicker = $block.find('.mr-clicker');
        console.log($mrClicker);
        let reachEnd = false;
       
        // Remove animating class when slide is transitioning.
        $mrSlider.on("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
            function(event) {
                $mrSlider.removeClass('animating');
                $mrClicker.removeClass('rewind forwards backwards');
        });

        $mrSlideClicker.on('click', function() {
            if($mrSlider.hasClass('animating'))    {
                return false;  
            }
            if( !reachEnd ) {
                mySwiper.slideNext();
            } else {
                $mrSlider.addClass( 'animating' );
                $mrClicker.addClass('rewind');
                mySwiper.slideTo(0, 3000);
                reachEnd = false;
            }
        });

        mySwiper.on('reachEnd', function() {
            reachEnd = true;
        })
        mySwiper.on('slideNextTransitionStart', function() {
            $mrSlider.addClass( 'animating' );
            $mrClicker.addClass('forwards');
        });


        mySwiper.on('slidePrevTransitionStart', function() {
            $mrSlider.addClass( 'animating' );
            $mrClicker.addClass('backwards');
        });

    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {

        console.log('in mr slider.js');
        $('.section-mr-slider').each(function () {
            initializeBlock($(this));
        });
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        window.acf.addAction('render_block_preview/type=mr-slider', initializeBlock);
        //    window.acf.addAction( 'render_block_preview', initializeBlock );
    }

})(jQuery);
