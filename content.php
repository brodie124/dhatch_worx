<?php if( has_post_thumbnail() ) { ?>
<div class="header-media">
	<?php if( is_single() ) {
		the_post_thumbnail('wide');
	}
	else { ?>
	<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('wide'); ?></a>
	<?php } ?>
</div>
<?php } ?>
	
<div class="entry-header">
<?php if( is_single() ) {
	the_title( '<h2 class="title post-title">', '</h2>' );
}
else {
	the_title( '<h2 class="title post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 
}?>
</div>