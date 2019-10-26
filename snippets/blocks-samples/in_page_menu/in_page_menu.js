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


    const initializeBlock = function ($block) {
        console.log('initializeBlock-in-page-menu');
        // load responsive background images
        $block.find('a[href*="#"]')
        // Remove links that don't actually link to anything
            .not('[href="#"]')
            .not('[href="#0"]')
            .on('click', function (event) {
                let $target = $(this.hash);
                if( $target.length ) {
                    pluginJs.scrollToSection($target[0])
                    return false;
                }
                
            });
    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {

        console.log('in in-page-menu.js');
        $('.section-in-page-menu').each(function () {
            console.log('in-page-menu found')
            initializeBlock($(this));
        });
    });

    // Initialize dynamic block preview (editor).
   // if (window.acf) {
    //    window.acf.addAction('render_block_preview/type=in-page-menu', initializeBlock);
        //    window.acf.addAction( 'render_block_preview', initializeBlock );
    //}

})(jQuery);
