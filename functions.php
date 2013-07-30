<?php
/**
 * _s functions and definitions
 *
 * @package _s
 */
$loader = include_once __DIR__ . '/vendor/autoload.php';
$loader->add( 'DBisso', __DIR__ . '/lib' );
$loader->add( 'Spliced', __DIR__ . '/lib' );

/**
 * Bootstrap or die
 */
try {
	if ( class_exists( '\DBisso\Util\Hooker' ) ) {
		$hooker = new DBisso\Util\Hooker;
		Spliced\Theme\Underscores\Core::bootstrap( $hooker );
	} else {
		throw new \Exception( 'Class DBisso\Util\Hooker not found. Check that the plugin is installed.', 1 );
	}
} catch ( \Exception $e ) {
	wp_die( $e->getMessage(), $title = 'Theme Exception' );
}
