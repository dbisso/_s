<?php
namespace Spliced\Theme\Underscores;

use DBisso\Util\Hooker;

/**
 * Instantiate the basic classes for the theme.
 */
class Bootstrap {
	/**
	 * Singleton instance.
	 *
	 * @var Bootstrap
	 */
	static $instance;

	/**
	 * Simple storage for the theme class instances.
	 *
	 * @var array
	 */
	public $container = array();

	/**
	 * Store the instance and kick things off
	 */
	public function __construct() {
		if ( ! self::$instance instanceof Bootstrap ) {
			self::$instance = $this;
		}

		/**
		 * Bootstrap or die
		 */
		try {
			if ( class_exists( '\DBisso\Util\Hooker' ) ) {
				$container =& $this->container;
				$container['hooker'] = new Hooker;
				$container['theme.core'] = new Core( $container['hooker'] );

				// new CustomHeader( $container['hooker'] );
				// new Updates( $container['hooker'] );
				// new Shortcodes( $container['hooker'] );
				// new PostTypes( $container['hooker'] );
				// new Taxonomies( $container['hooker'] );
				// new Plugins( $container['hooker'] );

				if ( is_admin() ) {
					$container['theme.admin'] = new Admin( $container['hooker'] );
				} else {
					$container['theme.frontend'] = new Frontend( $container['hooker'] );
				}
			} else {
				throw new \Exception( 'Class DBisso\Util\Hooker not found. Check that the plugin is installed.' );
			}
		} catch ( \Exception $e ) {
			wp_die( esc_html( $e->getMessage() ), 'Theme Exception' );
		}
	}
}

// Do the bootstrap.
new Bootstrap;

