<?php
/**
 * Blog Posts Block Template.
 *
 * @package mr-blocks
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockname = 'blog-posts';


$recent_posts = get_field( 'recent_posts' );
$blog_posts   = get_field( 'blog_posts' );


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();

$class_name = 'section-' . $blockname . ' not-loaded lazy ' . $margin;

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

$bposts = array();
if ( $recent_posts ) { // Get recent posts of category chosen.
	$bposts = get_posts(
		array(
			'posts_per_page' => 3,
			'cat'            => $recent_posts,
		)
	);
} elseif ( $blog_posts ) {  // Use posts selected.
	$bposts = $blog_posts;
} else {  // Otherwise get the three most recent posts.
	$bposts = get_posts(
		array(
			'posts_per_page' => 3,
		)
	);
}

if ( count( $bposts ) > 0 ) :
	add_filter( 'wp_get_attachment_image_attributes', 'mr_blocks_image_markup_responsive_background', 20, 2 );

	?>

	<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="container container--inner">

			<div class="row justify-content-center">
				<?php foreach ( $bposts as $pst ) : ?>
					<div class="col-12 col-md-4 mb-4">
						<div class="blog-post__container">
							<div class="blog-post__image mb-3">
								<a href="<?php echo esc_url( get_the_permalink( $pst->ID ) ); ?>">
									<div class="aspect-425">
										<?php echo wp_get_attachment_image( get_post_thumbnail_id( $pst->ID ), 'large' ); ?>
									</div>
								</a>
							</div>
							<div class="blog-post__title">
								<h2>
									<a href="<?php echo esc_url( get_the_permalink( $pst->ID ) ); ?>">
										<?php echo wp_kses_post( get_the_title( $pst->ID ) ); ?>
									</a>

								</h2>

								<div class="blog-post__author mb-3">
									<?php
									$post_author_id = get_post_field( 'post_author', $pst->ID );
									$author         = get_the_author_meta( 'display_name', $post_author_id )
									?>
									<?php echo 'By ' . esc_textarea( $author ); ?>
								</div>
								<div class="blog-post__excerpt mb-4">
									<?php echo wp_kses_post( get_the_excerpt( $pst->ID ) ); ?>
								</div>
							</div>
							<div class="blog-post__link">
								<a class="btn btn-primary"
								   href="<?php echo esc_url( get_the_permalink( $pst->ID ) ); ?>">
									READ MORE
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>


		</div>

	</section>

	<?php

	remove_filter( 'wp_get_attachment_image_attributes', 'mr_blocks_image_markup_responsive_background', 20, 2 );

endif;


