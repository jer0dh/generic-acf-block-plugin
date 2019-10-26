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

$blockname = 'business-logos';

$content                = get_field( 'content', null, false );
$background_color       = get_field( 'background_color' );
$is_centered_vertically = get_field( 'is_centered_vertically' );
$min_height             = get_field( 'min_height' );
$middle_wrap            = get_field( 'middle_wrap' );
$inner_wrap             = get_field( 'inner_wrap' );

$background = '';
if ( $background_color && 'none' !== $background_color ) {
	$background .= ' background--' . esc_attr( $background_color );
}


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


// Other
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'section-' . $blockname . ' not-loaded lazy ' . $margin . ' ' . $background;

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
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?>">
			<div class="row <?php echo ( $is_centered_vertically ) ? 'align-items-center' : ''; ?>"
				<?php echo ( $min_height ) ? 'style="min-height:' . esc_attr( $min_height ) . '"' : ''; ?>>
				<div class="col-12 <?php echo ( $padding ) ? esc_attr( $padding ) : ''; ?> <?php echo ( $is_centered_vertically ) ? 'rm-last-element-mb' : ''; ?>">
					<?php echo apply_filters( 'the_content', wp_kses_post( $content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php if ( have_rows( 'logos' ) ) : ?>

						<div class="business-logos">
							<?php
							while ( have_rows( 'logos' ) ) :
								the_row();
								$svg   = get_sub_field( 'svg_logo' );
								$image = get_sub_field( 'image_logo' );
								?>
								<div class="business-logo <?php echo ( $svg ) ? '--svg' : ''; ?>">
									<?php if ( $svg ) : ?>
										<?php echo wp_get_attachment_image( $svg['ID'], 'medium' ); ?>
									<?php else : ?>
										<?php echo wp_get_attachment_image( $image['ID'], 'medium' ); ?>
									<?php endif; ?>
								</div>


							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

<?php
