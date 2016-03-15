/* jQuery pacordion plugin
|* by Muhammad Morshed
|* https://www.github.com/morshedx/pacordion
|* version: 1.0
|* Created: December 7, 2015
|* Enjoy.
|* 
|* Thanks,
|* Morshed */

jQuery(function() {
	'use strict';
	
	var selector = jQuery('.ac-title');

	jQuery('.accordion-wrapper').each(function() {
		if (jQuery(this).find('.ac-pane').hasClass('active')) {
			jQuery('.ac-pane.active .ac-content').css('display', 'block');
		}
	});
	
	selector.on('click', function(event) {
		event.preventDefault();

		// get the attr value
		var attr = selector.attr('data-accordion');
		var getparent = jQuery(this).closest('.accordion-wrapper');

		if ( jQuery(this).attr('data-accordion') == 'true' ) {

		    if (jQuery(this).next('.ac-content').is(':visible')) {
		    	return false;
		    }else {

		    	getparent.find('.ac-content').slideUp();
		    	jQuery(this).next('.ac-content').slideDown();
		    	getparent.find('.ac-pane').removeClass('active');
		    	jQuery(this).parent().addClass('active');
		    }

		} else {
		    jQuery(this).next('.ac-content').slideToggle();
		    jQuery(this).parent().toggleClass('active');
		}
		
	});
});