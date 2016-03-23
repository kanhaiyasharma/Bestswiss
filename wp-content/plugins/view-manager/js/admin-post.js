( function ( jQuery ) {

	jQuery( document ).ready( function () {

		// post views input
		jQuery( '#post-views .edit-post-views' ).click( function () {
			if ( jQuery( '#post-views-input-container' ).is( ":hidden" ) ) {
				jQuery( '#post-views-input-container' ).slideDown( 'fast' );
				jQuery( this ).hide();
			}
			return false;
		} );

		// save post views
		jQuery( '#post-views .save-post-views' ).click( function () {

			var views = jQuery.trim( jQuery( '#post-views-display b' ).text() );

			jQuery( '#post-views-input-container' ).slideUp( 'fast' );
			jQuery( '#post-views .edit-post-views' ).show();

			views = parseInt( jQuery( '#post-views-input' ).val() );
			// reassign value as integer
			jQuery( '#post-views-input' ).val( views );

			jQuery( '#post-views-display b' ).text( views );

			return false;
		} );

		// cancel post views
		jQuery( '#post-views .cancel-post-views' ).click( function () {

			var views = jQuery.trim( jQuery( '#post-views-display b' ).text() );

			jQuery( '#post-views-input-container' ).slideUp( 'fast' );
			jQuery( '#post-views .edit-post-views' ).show();

			views = parseInt( jQuery( '#post-views-current' ).val() );

			jQuery( '#post-views-display b' ).text( views );
			jQuery( '#post-views-input' ).val( views );

			return false;
		} );

	} );

} )( jQuery );