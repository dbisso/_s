/* global Modernizr: true */
/**
 * Site wide Javascript goes here
 */
if ( Modernizr.svg ) {
	document.getElementsByTagName('html')[0].className = document.getElementsByTagName('html')[0].className.replace(/no-svg ?/,'');
}

