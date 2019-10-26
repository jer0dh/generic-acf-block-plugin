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

$blockname = 'service_grid';


$width            = get_field( 'width' );
$height           = get_field( 'height' );
$margin_btw       = get_field( 'margin_btw' );
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

add_filter( 'wp_get_attachment_image_attributes', 'mr_image_markup_responsive_background', 10, 2 );

?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?> ">
			<div class="row <?php echo esc_attr( $padding ); ?>">
				<div class="col-12">

				<?php if ( have_rows( 'grid_items' ) ) : ?>

				   <div class="service-grid-sg" style="margin-left: -<?php echo esc_attr( $margin_btw ); ?>">
			  
					 <?php
						while ( have_rows( 'grid_items' ) ) :
							the_row();
							$link_cat  = get_sub_field( 'link_cat' );
							$link_page = get_sub_field( 'link_page' );
							$clink     = ( $link_cat ) ? get_category_link( $link_cat ) : $link_page;
							$element   = 'div';
							$attribute = '';
							if ( $clink && ! $is_preview ) {
								$element   = 'a';
								$attribute = ' href="' . esc_url( $clink ) . '" ';
							}
							$full_content          = get_sub_field( 'full_content' );
							$background_color_full = get_sub_field( 'background_color_full' );
							$padding_full          = get_sub_field( 'padding_full' );

							$background_full = '';
							if ( $background_color_full && 'none' !== $background_color_full ) {
								$background_full .= ' background--' . esc_attr( $background_color_full );
							}

							$class_full = '';
							if ( $full_content ) {
								$class_full = 'sg-full-content ' . $background_full;
								if ( $padding_full ) {
									$class_full .= ' p-' . intval( $padding_full );
								}
							}
							?>

						
						<<?php echo $element . $attribute; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="sg-grid-item <?php echo ( $full_content ) ? esc_attr( $class_full ) : ''; ?>" style="margin-left: <?php echo esc_attr( $margin_btw ); ?>; margin-bottom: <?php echo esc_attr( $margin_btw ); ?>;
						width: <?php echo esc_attr( $width ); ?>; max-width: <?php echo esc_attr( $width ); ?>;
						min-height: <?php echo esc_attr( $height ); ?>" >


							<?php if ( $full_content ) : ?>
						   
								<?php echo apply_filters( 'the_content', wp_kses_post( $full_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

								<?php
							else :
								$image                   = get_sub_field( 'image' );
								$background_size         = get_sub_field( 'background_size' );
								$background_position     = get_sub_field( 'background_position' );
								$background_color_top    = get_sub_field( 'background_color_top' );
								$content                 = get_sub_field( 'content', false );
								$min_height_bottom       = get_sub_field( 'min_height_bottom' );
								$background_color_bottom = get_sub_field( 'background_color_bottom' );
								$background_top          = '';
								if ( $background_color_top && 'none' !== $background_color_top ) {
									$background_top .= ' background--' . esc_attr( $background_color_top );
								}
								$background_bottom = '';
								if ( $background_color_bottom && 'none' !== $background_color_bottom ) {
									$background_bottom .= ' background--' . esc_attr( $background_color_bottom );
								}
								?>
								<div class="sg-top <?php echo esc_attr( $background_top ); ?>" 
									style="background-size: <?php echo esc_attr( $background_size ); ?>;
									background-position: <?php echo esc_attr( $background_position ); ?>">
									<?php
									if ( $image ) {
										echo wp_get_attachment_image( $image['ID'], 'full' );
									}
									?>
								</div>
								<div class="sg-bottom rm-last-element-mb <?php echo esc_attr( $background_bottom ); ?>" 
									 style="min-height: <?php echo esc_attr( $min_height_bottom ); ?>">
									 <?php echo apply_filters( 'the_content', wp_kses_post( $content ) );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							
							<?php endif; ?>
						</<?php echo $element; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>> <!-- sg-grid-item -->
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

<?php
remove_filter( 'wp_get_attachment_image_attributes', 'mr_image_markup_responsive_background', 10, 2 );
