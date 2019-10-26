<?php
/**
 * In Page Menu Template.
 *
 * @package mr-blocks
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockname = 'in-page-menu';

$imenu                   = get_field( 'menu' );
$is_centered_vertically = get_field( 'is_centered_vertically' );
$min_height             = get_field( 'min_height' );
$middle_wrap            = get_field( 'middle_wrap' );
$inner_wrap             = get_field( 'inner_wrap' );
$background_color       = get_field( 'background_color' );
$font_size_larger       = get_field( 'font_size_larger' );


$background = '';
if ( $background_color && 'none' !== $background_color ) {
	$background .= ' background--' . esc_attr( $background_color );
}


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


// Other
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'section-' . $blockname . ' not-loaded lazy ' . $margin . ' ' . $background;

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

// create in page menu.
$inpage_menu = '';
$separator   = '<span> | </span>';
if ( $imenu ) {
	$inpage_menu = '<div class="in-page-menu">';
	foreach ( $imenu as $item ) {
		$inpage_menu .= '<a href="#' . esc_attr( $item['link'] ) . '">' . wp_kses_post( $item['label'] ) . '</a>';
		$inpage_menu .= $separator;
	}

	$inpage_menu  = substr( $inpage_menu, 0, strlen( $inpage_menu ) - strlen( $separator ) );
	$inpage_menu .= '</div>';
}

?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?> ">
			<div class="row <?php echo esc_attr( $padding ) . ( ( $is_centered_vertically ) ? ' align-items-center' : '' ); ?>"
				<?php echo ( $min_height ) ? 'style="min-height:' . esc_attr( $min_height ) . '"' : ''; ?>>
				<div class="col-12 <?php echo ( $is_centered_vertically ) ? 'rm-last-element-mb' : ''; ?>">
					<?php echo wp_kses_post( $inpage_menu ); ?>
				</div>
			</div>
		</div>
	</section>

<?php

