/* global jQuery:true, _:true */

/**
 * Trigger events based on MQ changes using same BP labels accross CSS and JS
 *
 * @example
 * $(document).on( 'mq.change', function changethings( event, mq ) {
 *  if ( mq.label === 'small' ) {
 *    // do something for small screens
 *  } else {
 *    // do something else
 *  }
 *
 *  if ( mq.index > 2 ) {
 *    // do something for all larger screens
 *  }
 * });
 * @param {Object} $ jQuery
 * @param {Object} DBisso Global namespace to nest things in
 * @author Dan Bissonnet <dan@danisadesigner.com>
 * @exports DBisso.MQ
 */
(function($, DBisso){
	/**
	 * Holds the last known media query data object
	 * @type {Boolean|Object}
	 */
	var current = false,
		delay = 350;

	/**
	 * Retrieve the current active media query data from viewport meta element
	 *
	 * @return {Object} Data object with media query, label and index
	 */
	function getCurrent() {
		// If there is no querySelector() (eg. IE < 8 ) then we do nothing as
		// old UAs genrally don't support media queries anyway.
		if ( 'undefined' !== typeof document.querySelector ) {
			// Get our viewport element where the data is stored
			var el = document.querySelector('meta[name="viewport"]');

			// Clean up data from CSS value and split into an array
			var mqData = String( getComputedStyle( el, null ).getPropertyValue( 'font-family' ) ).replace( /["']/g, '' ).split(',');

			if ( !mqData || mqData.length < 2 ) {
				return false;
			}

			return {
				mediaQuery: $.trim(mqData[2]),
				label: $.trim(mqData[1]),
				index: Number($.trim(mqData[0]))
			};
		}
	}

	/**
	 * Triggers mq.change with MQ data only when the media query has changed
	 * since we last checked.
	 */
	function maybeTriggerChange() {
		var data = getCurrent();
		if ( !current || ( current.index !== data.index ) ) {
			current = data;
			$(document).trigger( 'mq.change', data );
		}
	}

	// Bind to debounced resize event
	$(window).resize(_.debounce(maybeTriggerChange, delay));


	// Allow others to trigger initial test after they have bound their events.
	$(document).on( 'mq.init', function dBissoMQInit() {
		maybeTriggerChange();
	});

	/**
	 * @namespace Expose the public API
	 */
	DBisso.MQ = {
		maybeTriggerChange: maybeTriggerChange,
		getCurrent: getCurrent,
		delay: delay
	};
})( jQuery, window.DBisso = window.DBisso || {} );