<?php
namespace Spliced\Theme\Underscores;

use DBisso\Util\Hooker;

/**
 * Instantiate the basic classes for the theme.
 */
class Bootstrap {
	public $container = array();

	public function __construct() {
		/**
		 * Bootstrap or die
		 */
		try {
			if ( class_exists( '\DBisso\Util\Hooker' ) ) {
				$container = $this->container;

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

new Bootstrap;

