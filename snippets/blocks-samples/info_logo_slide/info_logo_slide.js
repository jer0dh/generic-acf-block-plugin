(function ($) {


    /**
     * initializeBlock
     *
     * Adds custom JavaScript to the block HTML.
     *
     * @date    15/4/19
     * @since   1.0.0
     *
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */
    const clickEvent = function(e) {
        let $this = $(this);
        if(! $this.hasClass('expanding')) {
          $this.addClass('expanding');
          $this.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
                function(event) {
            $this.removeClass('expanding');
          });
          $this.closest('.info-logo-slide').toggleClass('expanded');
        }
}

    const initializeBlock = function ($block) {
        console.log('initializeBlock-info-logo-slide');
        console.log( $block );
        // load responsive background images
        // const $bgImages = $block.find('img.responsive-background-image');
        // $bgImages.each(function () {
        //     pluginJs.loadBgImg(this);
        // })
        $block.find('.ils-info').on( 'click', clickEvent );
        //$('.ils-info-content').on('click', function() {return false});
    
    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {

        console.log('in info-logo-slide.js');
        initializeBlock($(this));
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        //window.acf.addAction('render_block_preview/type=info_logo_slide', initializeBlock);
        //    window.acf.addAction( 'render_block_preview', initializeBlock );
    }

})(jQuery);
