<?php
global $tt_option;
//$social_networks = $tt_option['footer_social_networks'];
$social_twitter = $tt_option['footer_social_twitter'];
$social_facebook = $tt_option['footer_social_facebook'];
$social_google = $tt_option['footer_social_google'];
$social_pinterest = $tt_option['footer_social_pinterest'];
$social_flickr = $tt_option['footer_social_flickr'];
$social_instagram = $tt_option['footer_social_instagram'];
$social_dribbble = $tt_option['footer_social_dribbble'];
$social_tumblr = $tt_option['footer_social_tumblr'];
$social_linkedin = $tt_option['footer_social_linkedin'];
$social_youtube = $tt_option['footer_social_youtube'];
$social_vimeo = $tt_option['footer_social_vimeo'];
?>

<footer id="footer">
	<div class="container">

		<?php
		if ( has_nav_menu('footer') ) {
			wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer-links', 'depth' => '1' ) );
		}
		?>
		<div class="social">
			<?php if($social_twitter) { ?><a href="<?php echo $social_twitter;?>"><i class="social-transparent fa fa-twitter fa-lg"></i></a><?php } ?>
			<?php if($social_facebook) { ?><a href="<?php echo $social_facebook;?>"><i class="social-transparent fa fa-facebook fa-lg"></i></a><?php } ?>
			<?php if($social_google) { ?><a href="<?php echo $social_google;?>"><i class="social-transparent fa fa-google-plus fa-lg"></i></a><?php } ?>
			<?php if($social_pinterest) { ?><a href="<?php echo $social_pinterest;?>"><i class="social-transparent fa fa-pinterest fa-lg"></i></a><?php } ?>
			<?php if($social_flickr) { ?><a href="<?php echo $social_flickr;?>"><i class="social-transparent fa fa-flickr fa-lg"></i></a><?php } ?>
			<?php if($social_instagram) { ?><a href="<?php echo $social_instagram;?>"><i class="social-transparent fa fa-instagram fa-lg"></i></a><?php } ?>
			<?php if($social_dribbble) { ?><a href="<?php echo $social_dribbble;?>"><i class="social-transparent fa fa-dribbble fa-lg"></i></a><?php } ?>
			<?php if($social_tumblr) { ?><a href="<?php echo $social_tumblr;?>"><i class="social-transparent fa fa-tumblr fa-lg"></i></a><?php } ?>
			<?php if($social_linkedin) { ?><a href="<?php echo $social_linkedin;?>"><i class="social-transparent fa fa-linkedin fa-lg"></i></a><?php } ?>
			<?php if($social_youtube) { ?><a href="<?php echo $social_youtube;?>"><i class="social-transparent fa fa-youtube fa-lg"></i></a><?php } ?>
			<?php if($social_vimeo) { ?><a href="<?php echo $social_vimeo;?>"><i class="social-transparent fa fa-vimeo-square fa-lg"></i></a><?php } ?>
		</div>
		<?php if ( $tt_option['footer_copyright'] ) { ?>
		<div class="copyright"><?php echo $tt_option['footer_copyright']; ?></div>
		<?php } ?>
		<div id="up"><a href="#"><i class="fa fa-angle-double-up"></i></a></div>

	</div>
</footer>

<?php wp_footer(); ?>

<script type="text/javascript">
    window.addEventListener("scroll", function() {
        if(window.scrollX > 0) {
            window.scrollTo(0, window.scrollY);
        }
    });
</script>
</body>
</html>
