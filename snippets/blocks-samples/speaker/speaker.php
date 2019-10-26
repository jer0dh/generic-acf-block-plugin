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

$blockname = 'speaker';

$content = get_field( 'content', null, false );
$name    = get_field( 'name' );
$stitle   = get_field( 'title' );
$image   = get_field( 'image' );

$middle_wrap      = get_field( 'middle_wrap' );
$inner_wrap       = get_field( 'inner_wrap' );
$background_color = get_field( 'background_color' );
$font_size_larger = get_field( 'font_size_larger' );


$background = '';
if ( $background_color && 'none' !== $background_color ) {
	$background .= ' background--' . esc_attr( $background_color );
}


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


// Other
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'section-' . $blockname . ' ' . $margin . ' ' . $background;

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
					<?php if ( $image ) : ?>
						<?php echo wp_get_attachment_image( $image['ID'], 'speaker', null, array( 'class' => 'speaker-image alignleft' ) ); ?>
					<?php endif; ?>
					<h2><?php echo wp_kses_post( $name ); ?></h2>
					<div class="speaker-title"><?php echo wp_kses_post( $stitle ); ?></div>

					<?php echo apply_filters( 'the_content', wp_kses_post( $content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		</div>
	</section>

<?php

