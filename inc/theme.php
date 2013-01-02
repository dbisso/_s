<?php
namespace Spliced\Theme {

class Underscores {
	static $_hooker;
	static $m;

	function bootstrap( $hooker = null ) {
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
	}

	function action_init() {
		// flush_rewrite_rules();
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
	function action_after_setup_theme() {

		/**
		 * Custom template tags for this theme.
		 */
		require( get_template_directory() . '/inc/template-tags.php' );

		/**
		 * Custom functions that act independently of the theme templates
		 */
		//require( get_template_directory() . '/inc/tweaks.php' );

		/**
		 * Custom Theme Options
		 */
		require( get_template_directory() . '/inc/theme-options/theme-options.php' );

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_s' to the name of your theme in all the template files
		 */
		load_theme_textdomain( '_s', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Register menus
		 */
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', '_s' ),
				'secondary' => __( 'Secondary Menu', '_s' ),
			)
		);

		/**
		 * Add support for the Aside Post Formats
		 */
		// add_theme_support( 'post-formats', array( 'aside', ) );

		add_image_size( 'post-thumbnail', 400, 200, true );
		add_image_size( 'slideshow-large', 960, 400, true );
	}

	function action_before() {
		?>
			<script type="text/javascript">
				document.getElementsByTagName('html')[0].className = document.getElementsByTagName('html')[0].className.replace('no-js','js');
			</script>
		<?php
	}

	function action_post_class( array $classes ) {
		$classes[] = 'copy-entry';
		$classes[] = 'stream wrapper-vertical-gutter';

		return $classes;
	}

	/**
	 * Register widgetized area and update sidebar with default widgets
	 *
	 * @since _s 1.0
	 */
	function action_widgets_init() {
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

	/**
	 * Remove some sidebars according to certain conditions
	 */
	// function action_before_sidebar () {
	// 	if ( // some conditions ) {
	// 		unregister_sidebar( 'sidebar-1' );
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

	function action__s_before_loop() {}


	function action_admin_enqueue_scripts() {}

	/**
	 * Enqueue scripts and styles
	 */
	function action_wp_enqueue_scripts() {
		$post = get_post();

		// $ctime = filectime( get_stylesheet_directory() . '/style.css' );
		wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', null, null );

		wp_enqueue_script( 'respond', 'http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js', null, null,false);
		// wp_enqueue_script( 'enquire', get_template_directory_uri() . '/js/enquire.js', null, null, true );

		// $ctime = filectime( get_stylesheet_directory() . '/js/small-menu.js' );
		wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), microtime(), true );

		// $ctime = filectime( get_stylesheet_directory() . '/js/script.js' );
		wp_enqueue_script( '_s', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), null, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
			wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
		}
	}

	/**
	 * Hide certain admin menus for site admins
	 * @param  array  $menu_order [description]
	 * @return [type]             [description]
	 */
	function filter_menu_order ( array $menu_order ) {
		global $menu, $submenu;
		static $wp_hook_priority = 13;

		$user = wp_get_current_user();

		$hidden_menus = array(
			'woodojo',
			'wpseo_dashboard',
			'edit.php?post_type=cfs',
			'edit-comments.php',
			'themes.php',
			'tools.php',
		);

		$hidden_options = array(
			'options-media.php',
			'options-permalink.php',
			'options-reading.php',
			'options-writing.php',
			'google-analytics-for-wordpress',
			'members-settings',
			'widget-css-classes-settings'
		);

		if ( in_array( 'site_admin', $user->roles ) ) {
			foreach ( $menu as $key => $menu_item ) {
				if ( in_array( $menu_item[2], $hidden_menus ) ) unset( $menu[$key] );
			}

			foreach ( $submenu['options-general.php'] as $key => $submenu_item ) {
				if ( in_array( $submenu_item[2], $hidden_options ) ) unset( $submenu['options-general.php'][$key] );
			}
		}

		return $menu_order;
	}

	function action_wp_dashboard_setup () {
		wp_add_dashboard_widget( 'spliced_welcome', 'Welcome', array( __CLASS__, 'widget_dashboard_welcome' ) );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );

		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	function widget_dashboard_welcome() {
		$user = wp_get_current_user();
		?>
		<h4>Hello <?php echo $user->user_firstname ?>,</h4>
		<p>Welcome to your site, built by <a href="http://spliced.co">Spliced Digital</a>.</p>
		<p>The site is currently under development so elements of the admin area may change, but feel free to explore the different areas.</p>
		<p>For example, try adding some temporary content if you like. (NB: it may get overridden during further development updates).</p>
		<p>If you have any questions, just <a href="mailto:admin@spliced.co">let us know</a></p>
		<p>Spliced Digital</p>
		<?php
	}

	function theme_filter_primary_content_class( array $classes ) {
		$classes[] = 'be-two-thirds-bp0';
		if ( !is_front_page() ) {
			// Custom classes for front page
		}
		$classes[] = 'stream wrapper-vertical-gutter';

		return $classes;
	}


	function insert_after_paragraph ( $count, $content, $insertion ) {
		return self::insert_after_tag( 'p', $count, $content, $insertion );
	}

	function insert_after_tag ( $tag, $count, $content, $insertion ) {
		if ( !function_exists( 'mb_convert_encoding' ) ) {
			trigger_error( 'Function insert_after_paragraph requires the PHP mbstring extension' );
			return $content;
		}

		libxml_use_internal_errors( true ); // Hide HTML DOM errors
		$dom = new \DomDocument( '1.0', 'utf-8' );

		// Convert encoding to preserve entities
		if ( !empty( $content ) && $dom->loadHTML( mb_convert_encoding( (string) $content, 'HTML-ENTITIES', 'UTF-8' ) ) ) {
			$xp      = new \DOMXPath( $dom );
			$p_nodes = $xp->query( '//' . $tag );
			$count   = (int) $count;

			if ( $p_nodes->length > 0 ) {
				$nth_plus_one_p_node = $p_nodes->item( $count );

				if ( is_object( $nth_plus_one_p_node ) ) {
					// Create a new \DomDocument to hold out last image node
					$ins = new \DomDocument( '1.0', 'utf-8' );
					$ins->loadHTML( mb_convert_encoding( "<html><body>$insertion</body></html>", 'HTML-ENTITIES', 'UTF-8' ) );

					foreach ( $ins->getElementsByTagName( 'body' )->item( 0 )->childNodes as $key => $node ) {
						$ins_node = $dom->importNode( $node );
						$nth_plus_one_p_node->parentNode->insertBefore( $ins_node, $nth_plus_one_p_node );
					}
				}
			}

			return $dom->saveHTML();
		}
	}

	private function include_post_content( $slug ) {
		$post = self::include_post( $slug );
		if ( current_user_can( 'edit_post', $post->ID ) ) {
			$meta = '<span class="edit"><a class="post-edit-link" href="' . get_edit_post_link( $post->ID ) . '" title="' . sprintf( esc_attr__( 'Edit %1$s', '_s' ), $post_type->labels->singular_name ) . '">' . __( 'Edit', '_s' ) . '</a></span>';
		}

		if ( !empty( $meta )  ) $meta = '<p class="entry-meta">' . $meta . '</p>';

		return apply_filters( 'the_content' , $post->post_content ) . $meta;
	}

	/**
	 * Get a single, published post by its slug
	 *
	 * @param  string $slug Post slug (post_name)
	 * @return object       Post object
	 */
	private function include_post( $slug ) {
		static $posts = array();

		if ( isset( $posts[$slug] ) ) return $posts[$slug];

		$args = array(
		  'name' => $slug,
		  'post_status' => 'publish',
		  'post_type' => 'any',
		  'showposts' => 1
		);

		$post = get_posts( $args );
		$post = $post[0];

		$posts[$slug] = $post;

		return $post;
	}

	function action_wp_head(){
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

	function action_wp_footer ( ) {
		if ( defined('WP_LOCAL_DEV') && true === WP_LOCAL_DEV ) echo '<div style="position: fixed; background: red; width: 20%; padding: 0.2em; bottom: 0; right: 0; color:white; font-size: 0.8em;">Local Development Mode</div>';
	}
}
} // End namespace

namespace Spliced\Theme\Underscores {
	spl_autoload_register(  __NAMESPACE__ . '\autoload' );

	try {
		if ( class_exists( '\Bisso_Hooker' ) ) {
			$hooker = new \Bisso_Hooker;
			// Updates::bootstrap( $hooker );
			// Shortcodes::bootstrap( $hooker );
			// Post_Types::bootstrap( $hooker );
			// Taxonomies::bootstrap( $hooker );
			// Plugins::bootstrap( $hooker );
		} else {
			throw new \Exception( 'Class Bisso_Hooker not found. Check that the plugin is installed.', 1 );
		}
	} catch ( Exception $e ) {
		wp_die( '[Theme _s]' . $e->getMessage(), $title = 'Theme Exception' );
	}

	// include_once dirname( __FILE__ ) . '/_s/microdata.php';

	function autoload( $name ) {
		$name     = array_pop( explode( '\\', $name ));
		$filename = dirname( __FILE__ ) . '/' . strtolower( $name ) . '.php';
		// var_dump($filename);

		if ( file_exists( $filename ) ) {
			require_once $filename;
		}
	}

	/**
	 * Template tag to apply filters to primary content class
	 *
	 * @param  array  $classes Additional classes
	 * @return string          Class attribute string
	 */
	function primary_content_class( array $classes = array() ) {
	  echo esc_attr( implode( ' ', apply_filters( '_s_primary_content_class', $classes ) ) );
	}

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 *
	 * @since _s 1.0
	 */
	if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

	/**
	 * Implement the Custom Header feature
	 */
	//require( get_template_directory() . '/inc/custom-header.php' );

	function get_featured_slider() {
		global $post, $cfs;

		$slides        = $cfs->get( 'flexslider_slides', $post->ID );
		$content       = '<div class="' . implode( ' ', apply_filters( 'bisso_flexslider_class', array( 'flexslider' ))) . '">
							<ul class="slides">';
		$slide_class   = ($classes = implode( ' ', apply_filters( 'bisso_flexslider_slide_class', array() ) ) ) ? "class='$classes'" : '';

		if ( !is_array( $slides ) or count( $slides ) == 0 ) {
			error_log( '[Spliced Theme] No slides specified for feature slider' );
			return '';
		}

		foreach ( $slides as $key => $slide ) {
			$attachment_id         = absint( $slide['slide_background_image'] );
			$caption_class_default = array(
				'flex-caption',
				'stack-' . strtolower( array_pop( $slide['slide_caption_alignment'] ) )
			);
			$caption_class         = ( $classes = implode( ' ', apply_filters( 'bisso_flexslider_caption_class', $caption_class_default  ) ) ) ? "class='$classes'" : '';
			$caption           = !empty( $slide['slide_caption'] ) ? do_shortcode( "<div $caption_class>{$slide['slide_caption']}</div>" ) : '';
			$content           .= "<li $slide_class >" . wp_get_attachment_image( $attachment_id, 'slideshow-large', false) . $caption . '</li>';
		}

		$content .= '</ul></div>';

		return $content;
	}

	function featured_slider() {
		echo get_featured_slider();
	}

	function front_page_programme_search_widget() {
		$args = array (
			'name'          => 'Sidebar',
			'id'            => 'sidebar-1',
			'description'   => '',
			'class'         => '',
			'before_widget' => '<aside id="homepage-search-widget" class="copy-gamma be-full-bp0 be-two-fifths-bp1 be-one-fifth-bp2 box delta">',
			'after_widget'  => '<div class="be-aligncenter-bp2 or-find-out-more skin-gutter-below
			"><p class="be-inline-block-bp0 be-block-bp2"><span class="skin-dark-crystal skin-circular">or</span></p> <a href="' . site_url( 'volunteer' ) . '" class="button call-to-action">Find out more about volunteering</a>
			</div></aside>',
			'before_title'  => '<h2 class="h beta">',
			'after_title'   => '</h2>',
		);

		$instance = array (
			'title' => 'Find a programme to sign up for',
			'mode'  => 'dropdowns',
			'taxonomies' => array (
				0 => Taxonomies::COMMITMENT,
				1 => Taxonomies::AGE,
				2 => Taxonomies::INTEREST_AREA,
			),
			'ids'     => '',
			'classes' => 'be-box-flesh-bp1 be-box-bp2 delta copy-naked',
		);

		the_widget( 'Taxonomy_Drill_Down_Widget', $instance, $args );
	}
}
