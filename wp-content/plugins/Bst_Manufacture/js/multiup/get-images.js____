

jQuery(document).ready(function($) {

	var formfield = null, formfielddeux = null, num ='';

	jQuery('.get-image').on( 'click', function() {
		jQuery('html').addClass('image_spe');
		num = jQuery(this).attr('data-num');
		formfield = jQuery('.id_img[data-num="'+num+'"]').attr('name');
		var id=jQuery("#post_ID").val();
		//tb_show('', 'media-upload.php?post_id='+id+'&type=image&TB_iframe=true');
		tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=true');
		return false;
	});

	jQuery('.del-image').on('click', function(){
		var cible = jQuery(this).attr('data-num');
		jQuery('.img-preview[data-num="'+cible+'"]').empty();
		jQuery('.id_img[data-num="'+cible+'"]').val('');
	});

	jQuery('.upload_pdf_button').live('click',function() {
		jQuery('html').addClass('pdf');
		num = jQuery(this).attr('data-cible');
		formfielddeux = jQuery('.url_pdf_input[data-input="'+num+'"]').attr('name');
		var id=jQuery("#post_ID").val();
		//tb_show('', 'media-upload.php?post_id='+id+'&type=file&TB_iframe=true');
		tb_show('', 'media-upload.php?post_id=0&type=file&TB_iframe=true');
		return false;
	});

	// user inserts file into post. only run custom if user started process using the above process
	// window.send_to_editor(html) is how wp would normally handle the received data

		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html){
	    var fileurl;
		if (formfield !== null) {
			var matches = html.match(/wp-image-([0-9]*)/);
			jQuery('input[name="'+formfield+'"]').val(matches[1]);
			var imgfull = jQuery(html).find('img').css({width:"100px", height:"100px"});
			jQuery('.img-preview[data-num="'+num+'"]').append(jQuery(imgfull));
			tb_remove();

			jQuery('html').removeClass('image_spe');
			formfield = null;
			num = null;
		}else{
			if(formfielddeux!== null){
				fileurl = jQuery(html).filter('a').attr('href');

				jQuery('.url_pdf_input[data-input="'+num+'"]').val(fileurl);

				tb_remove();

				jQuery('html').removeClass('pdf');
				formfielddeux = null;
				num = null;
			}else{
				window.original_send_to_editor(html);
			}
		}
	}


});