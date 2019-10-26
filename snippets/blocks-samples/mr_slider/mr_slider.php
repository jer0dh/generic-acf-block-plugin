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

$blockname = 'mr-slider';

$click_this_image = get_field( 'click_this_image' );
$click_this_text  = get_field( 'click_this_text' );
$background_image = get_field( 'background_image' );
$min_height       = get_field( 'min_height' );
$middle_wrap      = get_field( 'middle_wrap' );
$inner_wrap       = get_field( 'inner_wrap' );
$background_color = get_field( 'background_color' );
$font_size_larger = get_field( 'font_size_larger' );


$background = '';
if ( $background_color && $background_color != 'none' ) {
	$background .= ' background--' . esc_attr( $background_color );
}


$padding = mr_blocks_section_padding();
$margin  = mr_blocks_section_margin();


// Other
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'section-' . $blockname . $margin . ' ' . $padding . ' ' . $background;

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

$minh = '';
if ( $min_height ) {
	$minh = 'min-height:' . esc_attr( $min_height ) . ';';
}

$background_slide = '';
if ( $background_image ) {
	$background_slide = 'background-image: url(' . $background_image['url'] . ');';
}
?>

<section <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
<div class="mr-slide">
  <div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?>">
	<div class="mr-slide-clicker">
	  <div>
		<?php if ( $click_this_image ) : ?>
		  <img class="mr-clicker" src="<?php echo esc_url( $click_this_image['url'] ); ?>" width="" alt="Click for next">
		<?php endif; ?>
		<span><?php echo wp_kses_post( $click_this_text ); ?></span>
	  </div>
	</div>
</div>
<?php if ( have_rows( 'slides' ) ) : ?>


<div class="swiper-container">
	<!-- Additional required wrapper -->
	<div class="swiper-wrapper">
		<!-- Slides -->

	<?php
	while ( have_rows( 'slides' ) ) :
		the_row();
		$stitle  = get_sub_field( 'title' );
		$content = get_sub_field( 'content' );

		?>
		<div class="swiper-slide" style="<?php echo $minh . ';' . $background_slide; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">

		  <div class="mr-slide-content container <?php echo ( ( $inner_wrap ) ? 'container--inner' : '' ) . ( ( $middle_wrap ) ? ' container--middle' : '' ); ?>">
			<h2><?php echo wp_kses_post( $stitle ); ?></h2>
			<div class="<?php echo esc_attr( $background ); ?>"><?php echo wp_kses_post( $content ); ?></div> 
		  </div>
		</div>
<?php endwhile; ?>
	</div>
   
</div>
<?php endif; ?>
</div>
</section>


<?php
/*
	 <section <?php echo $attributes; ?>>
		<div class="container <?php echo ( $inner_wrap ) ? 'container--inner' : ''; ?> <?php echo ( $middle_wrap ) ? 'container--middle' : ''; ?> ">
			<div class="row <?php echo esc_attr( $padding ); ?>"
				<?php echo ( $min_height ) ? 'style="min-height:' . esc_attr( $min_height ) . '"' : ''; ?>>
				<div class="col-12">
					<?php echo apply_filters('the_content', wp_kses_post( $content ) ); ?>
				</div>
			</div>
		</div>
	</section>

 */

