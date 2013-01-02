<?php
/**
 * _s functions and definitions
 *
 * @package _s
 * @since _s 1.0
 */
include_once dirname(__FILE__) . '/inc/theme.php';

/**
 * Bootstrap or die
 */

try {
	if ( class_exists( '\Bisso_Hooker' ) ) {
		$hooker = new \Bisso_Hooker;
		\Spliced\Theme\Qace::bootstrap( $hooker );
	} else {
		throw new \Exception( 'Class Bisso_Hooker not found. Check that the plugin is installed.', 1 );
	}
} catch ( \Exception $e ) {
	wp_die( wp_get_theme() . ' theme bootstrap error: ' . $e->getMessage(),  wp_get_theme() . ' theme bootstrap error: ' );
}
