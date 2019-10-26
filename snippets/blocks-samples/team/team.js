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
        console.log('initializeBlock-team');
        // load responsive background images
        const $bgImages = $block.find('img.responsive-background-image');
        $bgImages.each(function () {
            pluginJs.loadBgImg(this);
        })
    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {

        console.log('in team block.js');
        $('.section-team').each(function () {
            initializeBlock($(this));
        });
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        window.acf.addAction('render_block_preview/type=team', initializeBlock);
        //    window.acf.addAction( 'render_block_preview', initializeBlock );
    }

})(jQuery);
