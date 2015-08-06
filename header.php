<?php
header('X-UA-Compatible: IE=edge,chrome=1');
global $tt_option;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>

<?php //die("<pre>" . print_r($tt_option, true) . "</pre>"); ?>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); if ( is_home() || is_front_page() ) { echo " | "; bloginfo('description'); } ?></title>
<?php
if( isset($tt_option['favicon']['url']) ) {
$favicon_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
$favicon = $favicon_protocol . str_replace(array('http:', 'https:'), '', $tt_option['favicon']['url']);
?><link rel="shortcut icon" href="<?php echo $favicon; ?>"><?php } ?>
<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
<![endif]-->
</head>
<body <?php body_class(); ?> data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
<div id="loadbox">
	<div class="wrapper">
		<div class="inner">
			<?php
			if( !empty($tt_option['logo_preloader']['url']) ) {
				$logo_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
			$logo_preloader = $logo_protocol . str_replace(array('http:', 'https:'), '', $tt_option['logo_preloader']['url']);
			?><img src="<?php echo $logo_preloader; ?>" alt="" /><?php } ?>
			<div class="spinner-css">
				<div class="dot1"></div>
				<div class="dot2"></div>
			</div>
		</div>
	</div>
</div>
<!-- DEMO ONLY -->



<header class="navbar<?php if ( is_home() || !is_front_page() || $tt_option['menu_show_always'] == "1" ) { echo ' show'; } if ( ( is_front_page() || is_page_template('demo-slideshow.php') || is_page_template('demo-video.php') ) && $tt_option['menu_style'] ) { echo ' transparent'; } ?>">
  <div class="container">

	  <div class="navbar-header">

		  <div class="brand-contact-number"><span class="glyphicon glyphicon-earphone"></span> <?php echo $tt_option['contact_phone']; ?></div>

    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
    	<span class="sr-only">Skip navigation</span>
    	<span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
	  </button>
	  <?php if( !empty($tt_option['logo_menu']['url']) ) { ?>
	  <div class="navbar-brand">
	    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $tt_option['logo_menu']['url']; ?>" alt="" /></a>
    </div>
    <?php } ?>
  </div>

  <nav class="collapse navbar-collapse" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-left', 'depth' => '2', 'walker'=> new Description_Walker ) ); ?>
		<div id="toggle-navbar"><i class="icon-angle-right"></i></div>
	</nav>

  </div>
</header>
