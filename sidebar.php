<div id="sidebar">
	<ul>
	<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
		<li class="widget"><?php get_search_form(); ?></li>
		<li class="widget">
			<div class="custom-heading"><h5 class="title"><span><?php _e('Categories', 'tt'); ?></span></h5></div>
			<ul><?php wp_list_categories( 'title_li=' ); ?></ul>
		</li>
		<li class="widget">
			<div class="custom-heading"><h5 class="title"><span><?php _e('Archive', 'tt'); ?></span></h5></div>
			<ul><?php wp_get_archives('type=monthly'); ?></ul>
		</li>
	<?php endif;
	?>
	</ul>
</div>