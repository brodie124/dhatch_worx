<a href="<?php echo get_post_meta( get_the_ID(), '_tt_blog_link_url', true ); ?>" rel="bookmark">
<div class="link-content">
	<h2 class="title post-title"><?php the_title(); ?></h2>
	<p class="lead"><?php echo get_post_meta( get_the_ID(), '_tt_blog_link_url', true ); ?></p>
</div>
</a>