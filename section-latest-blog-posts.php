<?php
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
					
		<ul class="latest-blog-posts row list-unstyled">			
		<?php
		$args = array( 'posts_per_page' => '3', 'ignore_sticky_posts' => 1 );
    $recent_posts = new WP_Query( $args );
    if( $recent_posts->have_posts() ) : while( $recent_posts->have_posts() ) : $recent_posts->the_post();
    ?>
    	<li class="col-sm-4">
				<div class="main-content">
					<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
						<div class="entry-inner">
							<div class="entry-content">		
				      	<?php 
				      	get_template_part( 'content', get_post_format() ); 
				      	the_excerpt();
				      	?>
			      	</div>
						</div>
					</article>
				</div>
			</li>
		<?php 
		endwhile; 
		endif; 
		wp_reset_postdata(); 
		?>
		</ul>				
		
	</div>
</div>