<?php
/**
 * Basic Content Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$blockname = 'team-member';



$background = '';
if ( $background_color && 'none' !== $background_color ) {
	$background .= ' background--' . esc_attr( $background_color );
}


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


// Other
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'section-' . $blockname . ' ' . $margin . ' ' . $background;

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

// Get meta info.


$ttitle           = get_field( 'team_member_title', $post_id );
$excerpt_title   = get_field( 'excerpt_title', $post_id );
$excerpt_content = get_field( 'excerpt_content', $post_id );
$photo           = get_field( 'photo', $post_id );

if ( ! $photo ) {
	$feature = get_post_thumbnail_id( $post_id );
	if ( '' !== $feature ) {
		$photo = array( 'ID' => $feature );
	}
}

?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container container--inner">
			<div class="row">
				<div class="col-12">

					<h1 class="team-member__name"><?php echo wp_kses_post( get_the_title( $post_id ) ); ?></h1>
					<?php if ( $ttitle ) : ?>
						<h2 class="team-member__title"><?php echo wp_kses_post( $ttitle ); ?></h2>
					<?php endif; ?>

					<?php if ( $excerpt_title ) : ?>
						<div class="team-member__excerpt-title"><?php echo wp_kses_post( $excerpt_title ); ?></div>
					<?php endif; ?>

					<?php if ( $excerpt_content ) : ?>
						<div class="team-member__excerpt-content"><?php echo wp_kses_post( $excerpt_content ); ?></div>
					<?php endif; ?>

					<?php if ( $photo ) : ?>
						<div class="team-member__photo"><?php echo wp_get_attachment_image( $photo['ID'], 'full' ); ?></div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</section>

<?php

