<?php
namespace Spliced\Theme\Underscores;

use DBisso\Util\HookerInterface;

/**
 * _s Theme Customizer
 *
 * @package _s
 */
class Customizer {
	public static $hooker;

	public static function bootstrap( HookerInterface $hooker ) {
		self::$hooker = $hooker->hook( __CLASS__, $hooker->hook_prefix );
	}

	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function action_customize_register( $wp_customize ) {
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

