<?php

		// register About Slider.
		acf_register_block_type(
			array(
				'name'            => 'mr-slider',
				'title'           => __( 'About Slider' ),
				'description'     => __( 'Add a menu' ),
				'render_template' => GENERIC_ACF_BLOCKS_PLUGIN_PATH . 'template-parts/blocks/mr_slider/mr_slider.php',
				'enqueue_style'   => GENERIC_ACF_BLOCKS_PLUGIN_PATH_URL . 'js/vendor/swiper.min.css',
				'enqueue_script'  => GENERIC_ACF_BLOCKS_PLUGIN_PATH_URL . 'js/vendor/swiper.min.js',
				'category'        => 'formatting',
				'icon'            => 'admin-comments',
				'keywords'        => array( 'marketing refresh', 'mr', 'slider' ),
				'mode'            => 'preview',
				'align'           => 'full',
				'supports'        => array(
					'align'  => array( 'full' ),
					'anchor' => true,
				),
			)
		);
