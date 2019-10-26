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

$blockname = 'title';


$ttitle       = get_field( 'title' );
$subtitle     = get_field( 'subtitle' );
$divider_line = get_field( 'divider_line' );
$middle_wrap  = get_field( 'middle_wrap' );
$inner_wrap   = get_field( 'inner_wrap' );

$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


// Other
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'section-' . $blockname . ' text-center ' . $margin;

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

$attributes .= ' class="' . esc_attr( $class_name ) . ' ' . esc_attr( $margin ) . '"';


?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?>">
			<div class="row">
				<div class="col-12">
					<?php if ( $ttitle ) : ?>
						<h2 class="section-title__title"><?php echo wp_kses_post( $ttitle ); ?></h2>
					<?php endif; ?>
					<?php if ( $subtitle ) : ?>
						<h3 class="section-title__subtitle"><?php echo wp_kses_post( $subtitle ); ?></h3>
						<?php
					endif;
					if ( $divider_line ) :
						?>
						<hr class="dotted" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

<?php


