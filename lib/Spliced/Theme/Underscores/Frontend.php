<?php
namespace Spliced\Theme\Underscores;
use Spliced\Theme\Underscores as T;

class Frontend {
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
	}

	function action_after_setup_theme() {
		// Include the custom template functions
		require( __DIR__ . '/helpers-template.php' );
	}

	/**
	 * Set js class on html as early as possible
	 * @return [type] [description]
	 */
	public function action_before() {
?><script type="text/javascript">document.getElementsByTagName('html')[0].className = document.getElementsByTagName('html')[0].className.replace('no-js','js');</script><?php
	}

	public function action_post_class( array $classes ) {
		$classes[] = 'stream wrapper-vertical-gutter';

		return $classes;
	}

	public function action__s_before_loop() {}

	/**
	 * Enqueue scripts and styles
	 */
	public function action_wp_enqueue_scripts() {
		$post = get_post();

		// Default Stylesheet
		wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', null, null );

		wp_enqueue_script( 'skip-link-focus', get_template_directory_uri() . '/js/skip-link-focus-fix.js', null, null, true );
		wp_enqueue_script( 'respond', 'http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js', null, null, false );
		// wp_enqueue_script( 'enquire', get_template_directory_uri() . '/js/enquire.js', null, null, true );
		wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), microtime(), true );
		wp_enqueue_script( '_s', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), null, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
			wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
		}
	}

	public function theme_filter_primary_content_class( array $classes ) {
		$classes[] = 'site-primary';
		if ( !is_front_page() ) {
			// Custom classes for front page
		}
		$classes[] = 'stream wrapper-vertical-gutter';

		return $classes;
	}

	public function action_wp_head(){
		$stylesheet_images_url = trailingslashit( get_stylesheet_directory_uri() );
		$stylesheet_images_dir = trailingslashit( get_stylesheet_directory() );

		if ( file_exists( $stylesheet_images_dir . 'images/favicon.ico' ) ) echo "<link rel='shortcut icon' href='{$stylesheet_images_url}images/favicon.ico' />";

		if ( file_exists( $stylesheet_images_dir . 'images/apple-touch-icon-144x144-precomposed.png' ) ) echo "<link rel='apple-touch-icon-precomposed' sizes='144x144' href='{$stylesheet_images_url}images/apple-touch-icon-144x144-precomposed.png' />";
		if ( file_exists( $stylesheet_images_dir . 'images/apple-touch-icon-114x114-precomposed.png' ) ) echo "<link rel='apple-touch-icon-precomposed' sizes='114x114' href='{$stylesheet_images_url}images/apple-touch-icon-114x114-precomposed.png' />";
		if ( file_exists( $stylesheet_images_dir . 'images/apple-touch-icon-72x72-precomposed.png' ) ) echo "<link rel='apple-touch-icon-precomposed' sizes='72x72' href='{$stylesheet_images_url}images/apple-touch-icon-72x72-precomposed.png' />";
		if ( file_exists( $stylesheet_images_dir . 'images/apple-touch-icon-57x57-precomposed.png' ) ) echo "<link rel='apple-touch-icon-precomposed' href='{$stylesheet_images_url}images/apple-touch-icon-57x57-precomposed.png' />";
		if ( file_exists( $stylesheet_images_dir . 'images/apple-touch-icon-precomposed.png' ) ) echo "<link rel='apple-touch-icon-precomposed' href='{$stylesheet_images_url}images/apple-touch-icon-precomposed.png' />";
		if ( file_exists( $stylesheet_images_dir . 'images/apple-touch-icon.png' ) ) echo "<link rel='apple-touch-icon-precomposed' href='{$stylesheet_images_url}images/apple-touch-icon.png' />";

		echo '<meta name="apple-mobile-web-app-title" content="' . __( 'Tower Hamlets EBP', '_s' ) . '">';
	}

	public function action_wp_footer ( ) {
		if ( defined('WP_LOCAL_DEV') && true === WP_LOCAL_DEV ) echo '<div style="position: fixed; background: red; width: 20%; padding: 0.2em; bottom: 0; right: 0; color:white; font-size: 0.8em;">Local Development Mode</div>';
	}

	/**
	 * Remove some sidebars according to certain conditions
	 */
	// function action_before_sidebar () {
	// 	if ( // some conditions ) {
	// 		unregister_sidebar( //sidebar-id );
	// 	}
	// }

	/**
	 * Modify certain widgets params
	 */
	// function filter_dynamic_sidebar_params ( array $params ) {
	// 	if ( strpos( $params[0]['widget_id'], '//some widget id') !== false ) {
	// 		$params[0]['before_title'] = '<h2 class="widget-title">';
	// 	}

	// 	return $params;
	// }

}