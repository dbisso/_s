<?php
namespace Spliced\Theme\Underscores;

/**
 * _s Theme Customizer
 *
 * @package _s
 */
class Customizer {
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
	}

	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function action_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	function customize_preview_init() {
		wp_enqueue_script( '_s_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
	}
}

