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

$blockname = 'case-study';

$ctitle               = get_field( 'title' );
$subtitle             = get_field( 'subtitle' );
$logo                 = get_field( 'logo' );
$content              = get_field( 'content', null, false );
$download_button_text = get_field( 'download_button_text' );
$case_study_file      = get_field( 'case_study_file' );
$link_to_page         = get_field( 'link_to_page' );
$case_study_thumbnail = get_field( 'case_study_thumbnail' );
$link_thumbnail       = get_field( 'link_thumbnail' );

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
$class_name = 'section-' . $blockname . $margin . ' ' . $background;

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

$content_class = 'col-12';
if ( $case_study_thumbnail ) {
	$content_class = 'col-md-7';
}

$clink = false;
if ( $case_study_file ) {
	$clink = $case_study_file['url'];
} elseif ( $link_to_page ) {
	$clink = $link_to_page;
}

?>

	<section <?php echo $attributes;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?> ">
			<div class="row <?php echo esc_attr( $padding ); ?>"
				<?php echo ( $min_height ) ? 'style="min-height:' . esc_attr( $min_height ) . '"' : ''; ?>>
				<?php if ( $case_study_thumbnail ) : ?>
					<div class="col-md-5 cs__thumbnail d-flex align-items-center justify-content-center mb-4 mb-md-0">
						<?php if ( $clink && $link_thumbnail ) : ?>
						  <a href="<?php echo esc_url( $clink ); ?>">
						<?php endif; ?>
						<?php echo wp_get_attachment_image( $case_study_thumbnail['ID'], 'full' ); ?>
						<?php if ( $clink && $link_thumbnail ) : ?>
						  </a>
						<?php endif; ?>
					   
					</div>
					<div class="<?php echo esc_attr( $content_class ); ?> d-flex align-items-start flex-column">
						<h2 class="text-center text-md-left"><?php echo wp_kses_post( $ctitle ); ?></h2>
						<?php if ( $logo ) : ?>
						<div class="row">
							<div class="col-sm-4 cs__logo mb-3 mb-sm-0">
								<?php echo wp_get_attachment_image( $logo['ID'], 'medium' ); ?>
							</div>
						<?php endif; ?>
							<div class="<?php echo ( $logo ? 'col-sm-8' : '' ); ?>">
								<h3><?php echo wp_kses_post( $subtitle ); ?></h3>
							</div>
							<?php if ( $logo ) : ?>
						</div> <!-- row -->
							<?php endif; ?>
							<div class="mb-4 cs__content">
								<?php echo apply_filters( 'the_content', wp_kses_post( $content ) );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>         
							</div>
							<?php if ( $clink ) : ?>
								<a class="btn btn-primary mt-auto" href="<?php echo esc_url( $clink ); ?>">
								<?php echo wp_kses_post( $download_button_text ); ?>
								</a>
							<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

<?php

