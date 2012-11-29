<?php
/**
 * _theme_name functions and definitions
 *
 * @package _theme_name
 * @since _theme_name 1.0
 */
include_once dirname(__FILE__) . '/inc/theme.php';

/**
 * Bootstrap or die
 */

try {
	if ( class_exists( '\Bisso_Hooker' ) ) {
		$hooker = new \Bisso_Hooker;
		\Spliced\Theme\Underscores::bootstrap( $hooker );
	} else {
		throw new \Exception( 'Class Bisso_Hooker not found. Check that the plugin is installed.', 1 );
	}
} catch ( Exception $e ) {
	wp_die( $e->getMessage(), $title = 'Theme Exception' );
}
