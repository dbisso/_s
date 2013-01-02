/*!
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);

/**
 * Micro plugin that removes one class and adds another
 * @param  {string} oldClass Class to remove
 * @param  {string} newClass Class to add
 */
(function($) {
	$.fn.swapClass = function( oldClass, newClass ) {
		return this.each( function() {
			var el = $( this );
			el.removeClass( oldClass ).addClass( newClass );
		});
	};
})(jQuery);

/**
 * Handles toggling the main navigation menu for small screens.
 */
(function($) {
	$.fn.smallMenu = function() {
		var menus = this,
			labels = menus.find( '.main-menu-label' );

		$(document).bind( 'smallMenu:change', function ( e, size ) {
			switch( size ) {
				case 'large':
					menus.swapClass( 'main-small-navigation', 'main-navigation' );
					labels.swapClass( 'menu-toggle', 'assistive-text' );
					break;
				case 'small':
					menus.swapClass( 'main-navigation', 'main-small-navigation' );
					labels.swapClass( 'assistive-text', 'menu-toggle' );
					break;
			}
		});

		labels.click( function() {
			var label = $(this),
				menu = $(this).parents( menus );
			// Don't respond if menu is not in small mode
			if ( menu.hasClass( 'main-small-navigation' ) ) {
				var labelText = label.text();

				menu.toggleClass( 'menu-visible' );
				label.text( label.data( 'label-alt' ) ).data( 'label-alt', labelText );
			}
		});

		return this;
	};
})(jQuery);

(function($){
	function smallMenu () {
		// Breakpoint name is stored in hidden psudo element on body.
		var breakpoint = String(getComputedStyle(document.body, '::before')['content']);
		$(document).trigger( 'smallMenu:change', $.inArray( breakpoint, ['bp1', 'bp2'] ) >= 0 ? 'large' : 'small' );
	}

	// Bind the menu
	$( '.site-navigation' ).smallMenu();

	// Bind to resize and trigger initial test.
	$(window).resize($.debounce(350, smallMenu)).resize();
})(jQuery);