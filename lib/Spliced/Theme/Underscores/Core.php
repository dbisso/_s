<?php
namespace Spliced\Theme\Underscores;

use DBisso\Util\HookerInterface;

/**
 * Core theme class
 *
 * Mainly for registering site-wide features and settings (post types, menus etc)
 */
class Core {
	/**
	 * @const Set the theme prefix.
	 */
	const HOOK_PREFIX = '_s';

	/**
	 * Hook the class.
	 *
	 * @param HookerInterface $hooker Hooker
	 */
	public function __construct( HookerInterface $hooker ) {
		$hooker->hook( $this, $this::HOOK_PREFIX );
	}

	/**
	 * Force some sensible defaults.
	 */
	public function action_after_switch_theme( $name, $theme ) {
		update_option( 'permalink_structure', '/%postname%/' );
		update_option( 'uploads_use_yearmonth_folders', 0 );
		flush_rewrite_rules( true );
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
		add_theme_support( 'title-tag' );
		add_theme_support(
			'html5',
			array( 'comment-list', 'comment-form', 'search-form', 'gallery' )
		);

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
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget--inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h2 class="widget--title">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Secondary Sidebar', '_s' ),
				'id'            => 'sidebar-2',
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget--inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h2 class="widget--title">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer', '_s' ),
				'id'            => 'footer-1',
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget--inner">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h2 class="widget--title">',
				'after_title'   => '</h2>',
			)
		);
	}
}