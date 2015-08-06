<?php 
get_header();

if (have_posts()) : while (have_posts()) : the_post();

global $post;
$slug = $post->post_name;

$background_color = get_post_meta( get_the_ID(), '_tt_page_background_color', true );
if ( $background_color ) { 
	echo '<style>#' . $slug . ', #' . $slug . ' .section-heading .title span, #' . $slug . ' .custom-heading .title span { background-color: ' . $background_color . '; }</style>'; 
}
?>

<div id="<?php echo $slug; ?>" class="section">
	<div class="container">
		<div class="section-heading text-center">
			<h2 class="title"><span><?php if( get_post_meta( get_the_ID(), '_tt_title', true ) ) { echo get_post_meta( get_the_ID(), '_tt_title', true ); } else { the_title(); } ?></span></h2>
			<?php if( get_post_meta( get_the_ID(), '_tt_subtitle', true ) ) { echo '<p class="subtitle">' . get_post_meta( get_the_ID(), '_tt_subtitle', true ) . '</p>'; } ?>
		</div>
		<div id="content">
			<?php the_content(); ?>
		</div>
	</div>
</div>

<?php
endwhile;
endif; 
wp_reset_query();

get_footer();
?>