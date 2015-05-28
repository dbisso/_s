<?php
/**
 * _s functions and definitions
 *
 * @package _s
 */

if ( version_compare( phpversion(), '5.3.5', '<' ) ) {
	wp_die( 'This theme requires PHP version 5.3.5 or higher' );
} else {
	$loader = include_once __DIR__ . '/vendor/autoload.php';
	$loader->add( 'DBisso', __DIR__ . '/lib' );
	$loader->add( 'Spliced', __DIR__ . '/lib' );

	// Call the bootstrap.
	include_once __DIR__ . '/bootstrap.php';
}

