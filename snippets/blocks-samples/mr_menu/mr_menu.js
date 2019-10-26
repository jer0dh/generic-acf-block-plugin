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
        console.log('initializeBlock-mr-menu');
       
        // 'a' used because using the li would prevent clicking the submenu since all in the parent li
        // 'menu-item-has-children so if a top level parent has no submenu and is a link
        $block.find('.menu > li.menu-item-has-children > a').on('click', function() {

            let $this = $(this).closest('li');

            let $subMenuContainer = $block.find('.mr-sub-menu');
            $subMenuContainer.empty()
            .removeClass('active');

            if( $this.hasClass('mr-selected')) {
                $this.removeClass('mr-selected');
                return false;
            }

            //find submenu
            $subMenu = $this.find('.sub-menu');
 
            if( $subMenu.length > 0 ) {
              const $copy = $subMenu.clone()

              $subMenuContainer.append( $copy )
                  .addClass( 'active' );
              // remove any previous selections    
              $block.find('.menu > li').removeClass('mr-selected');
              // make this selected
              $this.addClass('mr-selected');
              
              return false; // stop the bubble
            } else {
                return true; //keep event bubbling, maybe just a link
            }


        });

        $block.find( '.current-menu-parent > a' ).trigger('click');  //open current menu
        
        //if in editor, no links
        if(window.acf) {
            $block.find('a').removeAttr('href');
        }


    }

    // Initialize each block on page load (front end).
    $(document).ready(function () {

        console.log('in mr menu.js');
        $('.section-mr-menu').each(function () {
            initializeBlock($(this));
        });
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        window.acf.addAction('render_block_preview/type=mr-menu', initializeBlock);
        //    window.acf.addAction( 'render_block_preview', initializeBlock );
    }

})(jQuery);
