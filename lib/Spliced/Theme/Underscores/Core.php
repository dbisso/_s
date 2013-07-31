<?php
namespace Spliced\Theme\Underscores;

/**
 * Core theme class
 *
 * Mainly for registering site-wide features and settings (post types, menus etc)
 * Bootstraps the Frontend or Admin class as needed
 *
 */
class Core {
	static $_hooker;
	static $m;

	public function bootstrap( $hooker = null ) {
		if ( $hooker ) {
			if ( !method_exists( $hooker, 'hook' ) )
				throw new \BadMethodCallException( 'Class ' . get_class( $hooker ) . ' has no hook() method.', 1 );

			self::$_hooker = $hooker;
			self::$_hooker->hook( __CLASS__, '_s' );
		} else {
			throw new \BadMethodCallException( 'Hooking class for theme not specified.' , 1 );
		}

		// self::$m = new \Mustache_Engine( array(
		// 	'loader' => new \Mustache_Loader_FilesystemLoader( get_stylesheet_directory() . '/templates' ),
		// 	'helpers' => array(
		// 		'__' => function( $text ) {
		// 			return __( $text, '_s' );
		// 		}
		// 	)
		// ));

		// CustomHeader::bootstrap( $hooker );
		// Updates::bootstrap( $hooker );
		// Shortcodes::bootstrap( $hooker );
		// PostTypes::bootstrap( $hooker );
		// Taxonomies::bootstrap( $hooker );
		// Plugins::bootstrap( $hooker );
		// Insert::bootstrap( $hooker );

		if ( is_admin() )
			Admin::bootstrap( $hooker );
		else
			Frontend::bootstrap( $hooker );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * @since _s 1.0
	 */
	public function action_after_setup_theme() {
		load_theme_textdomain( '_s', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		// add_theme_support( 'custom-header' );
		// add_theme_support( 'post-formats', array( 'aside', ... ) );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', '_s' ),
				'secondary' => __( 'Secondary Menu', '_s' ),
			)
		);

		add_image_size( 'post-thumbnail', 400, 200, true );
		add_image_size( 'slideshow-large', 960, 400, true );
	}

	public function action_init() {
		// flush_rewrite_rules();
	}

	/**
	 * Register widgetized area and update sidebar with default widgets
	 *
	 * @since _s 1.0
	 */
	public function action_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Sidebar', '_s' ),
				'id'            => 'sidebar-1',
				'before_widget' => '<aside id="%1$s" class="widget be-full-bp0 %2$s"><div class="inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h2 class="widget-title be-ear-left-bp2">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Secondary Sidebar', '_s' ),
				'id'            => 'sidebar-2',
				'before_widget' => '<aside id="%1$s" class="widget be-full-bp0 %2$s"><div class="inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h2 class="widget-title be-ear-left-bp2">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer', '_s' ),
				'id'            => 'footer-1',
				'before_widget' => '<aside id="%1$s" class="widget be-full-bp0 be-one-quarter-bp1 be-box-flesh-bp1 skin-beta %2$s"><div class="inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h2 class="">',
				'after_title'   => '</h2>',
			)
		);
	}
}