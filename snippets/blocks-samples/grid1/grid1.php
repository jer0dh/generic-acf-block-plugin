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

$blockname = 'grid1';


$content          = get_field( 'content', null, false );
$background_color = get_field( 'background_color' );

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
		<div class="container container--inner">
			<?php if ( have_rows( 'items' ) ) : ?>
				<div class="row">
					<div class="col-12 grid1-items">
						<?php
						while ( have_rows( 'items' ) ) :
							the_row();
							$icon    = get_sub_field( 'icon' );
							$content = get_sub_field( 'content' );
							$clink   = get_sub_field( 'link' );
							$class   = get_sub_field( 'class' );
							?>

							<div class="grid1-item <?php echo ( $class ) ? esc_attr( $class ) : ''; ?>">

								<div class="grid1-image ">
									<?php if ( false !== $clink ) : ?>
									<a href="<?php echo esc_url( $clink ); ?>">
										<?php endif; ?>

										<?php if ( $icon && 'none' !== $icon ) : ?>
											<div class="aspect-667">
												<div class="absolute-full --svg">
													<?php
													echo mr_blocks_ea_icon(   // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
														array(
															'icon' => $icon,
															'group' => 'light',
															'size' => '100%',
														)
													);
													?>
												</div>
											</div>
										<?php endif; ?>

										<?php if ( false !== $clink ) : ?>
									</a>
								<?php endif; ?>
								</div>
								<div class="grid1-content">
									<?php echo apply_filters( 'the_content', wp_kses_post( $content ) );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>

							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>

<?php

