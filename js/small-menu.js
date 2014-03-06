/* global jQuery:true, _:true */

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

		$(document).bind( 'smallMenu.change', function ( e, size ) {
			switch( size ) {
				case 'large':
					menus.swapClass( 'main-small-navigation', 'main-navigation' );
					labels.swapClass( 'menu-toggle', 'assistive-text' );
					menus.insertAfter( '.site-branding' );
					break;
				case 'small':
					menus.swapClass( 'main-navigation', 'main-small-navigation' );
					labels.swapClass( 'assistive-text', 'menu-toggle' );
					menus.insertBefore( '.site' );
					break;
			}
		});

		return this;
	};
})(jQuery);

(function($){
	// Bind the menu
	$( '#site-navigation' ).smallMenu().uncomment();

	// Enable click/touch to reveal
	$( '.menu-toggle' ).attr('href', '#').click( function( event ) {
		event.preventDefault();

		var label = $(this),
			menu = $( '#' + label.data('menu') );

		menu.trigger( 'menu.show' );

		// Don't respond if menu is not in small mode
		if ( menu.hasClass( 'main-small-navigation' ) ) {
			var labelText = label.text();
			$('body').toggleClass( 'menu-visible' );
			menu.toggleClass( 'menu-visible' );
			label.toggleClass( 'menu-visible' );
			label.text( label.data( 'label-alt' ) ).data( 'label-alt', labelText );
		}
	});

	// Trigger the menu change depending on MQ
	function maybeSmallMenu( event, mqData ) {
		var menuState = mqData.index >= 1 ? 'large' : 'small';
		$(document).trigger( 'smallMenu.change', menuState );
	}

	// Bind to media query change
	$(document).on( 'mq.change', maybeSmallMenu );

	// Trigger initial change
	$(document).trigger( 'mq.init' );
})(jQuery);