/* First we need this awesome little "jQuery uncomment" plugin
 * Author: Romuald Brunet <romuald@chivil.com>
 * http://chivil.com/uncomment/
 */
(function($) {
  $.fn.uncomment = function(recurse) {
    $(this).contents().each(function() {
      if ( recurse && this.hasChildNodes() ) {
      	$(this).uncomment(recurse);
			} else if ( this.nodeType == 8 ) {
				// Need to "evaluate" the HTML content,
				// otherwise simple text won't replace
				var e = $('<span>' + this.nodeValue + '</span>');
				$(this).replaceWith(e.contents());
			}
		});
	};
})(jQuery);