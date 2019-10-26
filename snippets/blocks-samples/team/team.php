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

$blockname = 'team';

$inner_wrap       = get_field( 'inner_wrap' );
$middle_wrap      = get_field( 'middle_wrap' );
$background_color = get_field( 'background_color' );


$background = '';
if ( $background_color && 'none' !== $background_color ) {
	$background .= ' background--' . esc_attr( $background_color );
}


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


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


add_filter( 'wp_get_attachment_image_attributes', 'mr_image_markup_responsive_background', 10, 2 );


?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container-fluid <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?>">
			<div class="row <?php echo esc_attr( $padding ); ?>">

				<?php if ( have_rows( 'team_squares' ) ) : ?>

					<?php
					while ( have_rows( 'team_squares' ) ) :
						the_row();
						$team_member = get_sub_field( 'team_member' );
						$content     = get_sub_field( 'content', false );
						?>
						<div class="col-12 col-sm-6 col-md-4 team__square d-flex flex-column justify-content-center ">
							<?php
							if ( $team_member ) {
								$name            = get_the_title( $team_member );
								$ttitle          = get_field( 'team_member_title', $team_member );
								$excerpt_title   = get_field( 'excerpt_title', $team_member );
								$excerpt_content = get_field( 'excerpt_content', $team_member );
								$image           = get_post_thumbnail_id( $team_member );
								if ( '' !== $image ) {
									echo wp_get_attachment_image( $image, 'large' );
								}
								?>
								<div class="team__mobile-info d-block d-sm-none">
									<h4>
										<a href="<?php echo esc_url( get_permalink( $team_member ) ); ?>"><?php echo wp_kses_post( $name ); ?></a>
									</h4>
									<h5><?php echo wp_kses_post( $ttitle ); ?></h5>
								</div>
								<div class="team__overlay text-white">
									<div>
										<div>
											<h4 class="text-white mb-0"><?php echo wp_kses_post( $name ); ?></h4>
											<h5 class="text-white"><?php echo wp_kses_post( $ttitle ); ?></h5>
										</div>
										<div>
											<div class="team__overlay__excerpt-title"><?php echo wp_kses_post( $excerpt_title ); ?></div>
											<div class="mb-2"><?php echo wp_kses_post( $excerpt_content ); ?></div>
											<a class="text-white btn-arrow"
											   href="<?php echo esc_url( get_permalink( $team_member ) ); ?>"><strong>+ More
													Info</strong></a>
										</div>
									</div>
								</div>

								<?php
							} elseif ( $content ) {
								?>
								<div class="team__content rm-last-element-mb">
									<?php echo apply_filters( 'the_content', wp_kses_post( $content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
								<?php
							}
							?>

						</div>
					<?php endwhile; ?>

				<?php endif; ?>

			</div>
		</div>
	</section>

<?php
remove_filter( 'wp_get_attachment_image_attributes', 'mr_image_markup_responsive_background', 10, 2 );

