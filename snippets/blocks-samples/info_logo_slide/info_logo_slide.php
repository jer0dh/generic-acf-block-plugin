<?php
/**
 * Info Logo Slide Template.
 *
 * @package mr-blocks
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockname = 'info_logo_slide';

$content        = get_field( 'content', null, false );
$logo_img       = get_field( 'logo_img' );
$logo_svg       = get_field( 'logo_svg' );
$background_img = get_field( 'background_img' );
$background_top = get_field( 'background_top' );

$min_height       = get_field( 'min_height' );
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

$ils_background = '';
if ( $background_img ) {

	$ils_background  = 'background-image: linear-gradient( rgba(255,255,255,0.5), rgba(255,255,255,0.5)),';
	$ils_background .= 'url(' . esc_url( $background_img ) . ');';
}
$ils_background_top = 'background-position: center;';
if ( is_numeric( $background_top ) ) {
	$ils_background_top = 'background-position: center ' . intval( $background_top ) . '%;';
}


?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?> ">
			<div class="row <?php echo esc_attr( $padding ); ?>">
				<div class="col-12">
					<div class="info-logo-slide ils">
						<div class="ils-bg-container">
							<div></div>
							<div style="<?php echo esc_attr( $ils_background . $ils_background_top ); ?>"></div>
						</div>
						<div class="ils-content-container" <?php echo ( $min_height ) ? 'style="min-height:' . esc_attr( $min_height ) . '"' : ''; ?>>
							<div class="ils-info"><span class="dashicons dashicons-no"></span><span class="dashicons dashicons-arrow-right-alt"></span>
								<div class="ils-info-content">
									<?php echo apply_filters( 'the_content', wp_kses_post( $content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>
							<div class="ils-logo">
								<?php if ( $logo_svg ) : ?>
									<?php echo wp_get_attachment_image( $logo_svg['ID'], 'medium' ); ?>
								<?php elseif ( $logo_img ) : ?>
									<?php echo wp_get_attachment_image( $logo_img['ID'], 'medium' ); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php

