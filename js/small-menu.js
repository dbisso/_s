/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery.fn.smallMenu = function() {
	this.each( function() {
		var el = jQuery( this );

		if ( el.hasClass( 'main-small-navigation' ) ) {
			el.removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
			el.find( '.menu-toggle' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' ).unbind( 'click' );
			el.find( '.menu' ).removeAttr( 'style' );

			return;
		}

		el.removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
		el.find( 'h1.assistive-text' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' ).click( function() {
			el.find( '.menu' ).toggle();
			jQuery( this ).toggleClass( 'toggled-on' );
		});
	});
};

jQuery( document ).ready( function( $ ) {
	if ( "undefined" === typeof window.enquire ) {
		return;
	}

	var smallMenus = $( '.site-navigation' );

	enquire.register( "screen and (max-width: 50em)", {
		match: function() {
			smallMenus.smallMenu();
			$('body:not(".home") .site-header').hide();
		},
		unmatch: function() {
			smallMenus.smallMenu();
			$('body:not(".home") .site-header').show();
		}
	}).fire().listen();
} );