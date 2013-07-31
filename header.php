<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package _s
 */
use Spliced\Theme\Underscores as T;
?><!DOCTYPE html>
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="no-js ie6 oldie no-boxsizing no-svg"> <![endif]-->
<!--[if IE 7]><html <?php language_attributes(); ?> class="no-js ie7 oldie no-boxsizing no-svg"> <![endif]-->
<!--[if IE 8]><html <?php language_attributes(); ?> class="no-js ie8 oldie no-svg"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js no-boxsizing no-svg"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php esc_attr_e( get_template_directory_uri() ) ?>/js/html5shiv.js" type="text/javascript"></script>
	<link id="oldie-styles" rel="stylesheet" href="<?php esc_attr_e( get_template_directory_uri() ) ?>/oldie.css" />
	<![endif]-->
	<!--[if IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.0/IE8.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
		</div>

		<nav role="navigation" class="site-navigation main-navigation">
			<h1 class="main-menu-label assistive-text"><?php _e( 'Menu', '_s' ); ?></h1>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', '_s' ); ?>"><?php _e( 'Skip to content', '_s' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->
	</header><!-- #masthead .site-header -->

	<div id="content" class="site-content">
