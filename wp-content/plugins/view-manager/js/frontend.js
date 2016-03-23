( function ( jQuery ) {

	jQuery( document ).ready( function () {

		jQuery.post( pvcArgsFrontend.ajaxURL, {
			action: 'pvc-check-post',
			pvc_nonce: pvcArgsFrontend.nonce,
			post_id: pvcArgsFrontend.postID,
			post_type: pvcArgsFrontend.postType,
			istax: pvcArgsFrontend.istax
		} );

	} );

} )( jQuery );