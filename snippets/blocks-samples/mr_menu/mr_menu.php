<?php
/**
 * Basic Content Block Template.
 *
 * @package mr-blocks
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockname = 'mr-menu';

$mrmenu             = get_field( 'mr_menu' );
$middle_wrap      = get_field( 'middle_wrap' );
$inner_wrap       = get_field( 'inner_wrap' );
$font_size_larger = get_field( 'font_size_larger' );


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


// Other
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'section-' . $blockname . ' ' . $margin;

if ( $font_size_larger ) {
	$class_name .= ' font-size-larger';
}

if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Create id attribute allowing for custom "anchor" value.
$block_id = $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}


$attributes = '';
if ( $block_id ) {
	$attributes .= ' id="' . esc_attr( $block_id ) . '" ';
}

$attributes .= ' class="' . esc_attr( $class_name ) . '"';


?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?> ">
			<div class="row <?php echo esc_attr( $padding ); ?>">
				<div class="col-12">
					<?php
					$nav = wp_nav_menu(
						array(
							'menu'           => $mrmenu,
							'theme_location' => '',
							'container'      => '',
							'menu_class'     => 'menu genesis-nav-menu',
							'link_before'    => genesis_markup(
								array(
									'open'    => '<span %s>',
									'context' => 'nav-link-wrap',
									'echo'    => false,
								)
							),
							'link_after'     => genesis_markup(
								array(
									'close'   => '</span>',
									'context' => 'nav-link-wrap',
									'echo'    => false,
								)
							),
							'echo'           => 0,
						)
					);
							echo '<nav class="mr-menu">' . $nav . '</nav>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
					<div class="mr-sub-menu"></div>
				</div>
			</div>
		</div>
	</section>

<?php

