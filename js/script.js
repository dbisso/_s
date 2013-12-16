/**
 * Site wide Javascript goes here
 */
;jQuery( function($) {
 	if ( Modernizr.svg ) {
		document.getElementsByTagName('html')[0].className = document.getElementsByTagName('html')[0].className.replace(/no-svg ?/,'');
	}
});
