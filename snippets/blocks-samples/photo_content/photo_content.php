<?php
/**
 * Photo & Content Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockname = 'photo-content';

$content = get_field( 'content', null, false );

$image                  = get_field( 'image' );
$inner_wrap             = get_field( 'inner_wrap' );
$middle_wrap            = get_field( 'middle_wrap' );
$image_on_right         = get_field( 'image_on_right_side' );
$show_image_on_mobile   = get_field( 'show_image_on_mobile' );
$image_position         = get_field( 'image_position' );
$is_centered_vertically = get_field( 'is_centered_vertically' );
$min_height             = get_field( 'min_height' );
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
$class_name = 'section-' . esc_attr( $blockname ) . ' not-loaded lazy ' . $margin;

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

add_filter( 'wp_get_attachment_image_attributes', 'mr_blocks_image_markup_responsive_background', 10, 2 );
?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?>
			<?php echo ( $middle_wrap ) ? 'container--middle ' : ''; ?>
			<?php echo esc_attr( $background ); ?>">
			<div class="row <?php echo esc_attr( $padding ); ?>">
				<div class="col-12 col-md-6 order-1 <?php echo ( $is_centered_vertically ) ? ' d-flex align-items-center' : ''; ?>"
					<?php echo ( $min_height ) ? ' style="min-height:' . esc_attr( $min_height ) . '"' : ''; ?>>
					<div class="<?php echo ( $is_centered_vertically ) ? 'rm-last-element-mb' : ''; ?> p-3">
						<?php echo apply_filters( 'the_content', wp_kses_post( $content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
				<div class="col-12 col-md-6 align-self-stretch <?php echo ( $image_on_right ) ? 'order-md-2' : ''; ?>
					<?php echo ( $show_image_on_mobile ) ? '' : ' d-none d-md-block'; ?>" style="
				<?php echo ( $min_height ) ? ' min-height:' . esc_attr( $min_height ) . ';' : ''; ?>
				<?php echo ( $image_position ) ? 'background-position:' . esc_attr( $image_position ) . ';' : ''; ?>">
					<?php
					if ( $image ) {
						echo wp_get_attachment_image( $image['ID'], 'large' );
					}
					?>

				</div>
			</div>
		</div>
	</section>

<?php

remove_filter( 'wp_get_attachment_image_attributes', 'mr_blocks_image_markup_responsive_background', 10, 2 );
