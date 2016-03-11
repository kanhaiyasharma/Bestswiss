<?php

/**
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 5. GLOBALS ↓
* @uses list_images (HOOK FILTER) : to rewrite images keys
* @uses images_cpt (HOOK FILTER) : to target cpt whith the image metabox
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
function list_my_images_slots( $cpt = false ){
	$list_images = apply_filters('list_images',array(
		'image1' => '_image1',
		'image2' => '_image2',
		'image3' => '_image3',
		'image4' => '_image4',
		'image5' => '_image5',
		'image6' => '_image6',
		'image7' => '_image7',
		'image8' => '_image8'
		), $cpt );
	return $list_images;
}
	
/** 
A) INITIALIZE
*/
add_action("admin_init", "add_image_metabox");
function add_image_metabox(){
	
}


 add_action('yith_shop_vendor_edit_form_fields', 'yith_shop_vendor_metabox_editgal', 10, 1);    
    function yith_shop_vendor_metabox_editgal($tgid){
         
         ?>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="Untertitel">gallery</label></th>
                <td> 
                 <?php
                    
                    $cpts = apply_filters('images_cpt', array('yith_shop_vendor'));
                    $screen = get_current_screen();

					/*foreach($cpts as $cpt){
						add_meta_box('imagesliees', __('Add Photos'), "imagesliees", null, 'normal', 'core');
					}*/

					imagesliees($tgid);


                    ?>
                </td>
            </tr>

         <?php
    }

/**
B) SAVE METABOX 
*/
add_action('save_post', 'save_image_metabox'); 
function save_image_metabox($post_ID){ 
	// on retourne rien du tout s'il s'agit d'une sauvegarde automatique
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
    
   	$list_images = list_my_images_slots();
    foreach($list_images as $k => $i){
	    if ( isset( $_POST[$k] ) ) {
			check_admin_referer('image-liee-save_'.$_POST['post_ID'], 'image-liee-nonce');
			update_post_meta($post_ID, $i, esc_html($_POST[$k])); 
		}
	}
}

/**	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// C) FUNCTIONS BUILDING THE META BOX ↓
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
/**
// IMAGES
*/
function imagesliees($post){
	
	$list_images = list_my_images_slots();

	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( 'quicktags' );
	wp_enqueue_script( 'jquery-ui-resizable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-button' );
	wp_enqueue_script( 'jquery-ui-position' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_script( 'wpdialogs' );
	wp_enqueue_script( 'wplink' );
	wp_enqueue_script( 'wpdialogs-popup' );
	wp_enqueue_script( 'wp-fullscreen' );
	wp_enqueue_script( 'editor' );
	wp_enqueue_script( 'word-count' );

	wp_enqueue_script( 'img-mb', plugin_dir_url().'Bst_Manufacture/js/multiup/get-images.js', array( 'jquery','media-upload','thickbox','set-post-thumbnail' ) );
	wp_enqueue_style( 'thickbox' );

	wp_nonce_field( 'image-liee-save_'.$post->term_id, 'image-liee-nonce');

	echo '<div id="droppable">';
	$z =1;

	foreach($list_images as $k=>$i){
		$meta = get_post_meta($post->term_id,$i,true);
		$img = (isset($meta)) ? '<img src="'.wp_get_attachment_thumb_url($meta).'" width="100" height="100" alt="" draggable="false">' : '';
		echo '<div class="image-entry" draggable="true">';
		echo '<input type="hidden" name="'.$k.'" id="'.$k.'" class="id_img" data-num="'.$z.'" value="'.$meta.'">';
		echo '<div class="img-preview" data-num="'.$z.'">'.$img.'</div>';
		echo '<a href="javascript:void(0);" class="multiimageupload" data-num="'.$z.'">'._x('Add New','file').'</a><a href="javascript:void(0);" class="del-image button-secondary" data-num="'.$z.'">'.__('Delete').'</a>';
		echo '</div>';
		$z++;
	}
	echo '</div>';
	?>

	<div style="clear:left;"></div>
	<script>jQuery(document).ready(function($){
		function reorderImages(){
			//reorder images
			jQuery('#droppable .image-entry').each(function(i){
				//rewrite attr
				var num = i+1;
				jQuery(this).find('.get-image').attr('data-num',num);
				jQuery(this).find('.del-image').attr('data-num',num);
				jQuery(this).find('div.img-preview').attr('data-num',num);
				var $input = jQuery(this).find('input');
				$input.attr('name','image'+num).attr('id','image'+num).attr('data-num',num);
			});
		}

		if('draggable' in document.createElement('span')) {
			function handleDragStart(e) {
			  this.style.opacity = '0.4';  // this / e.target is the source node.
			}

			function handleDragOver(e) {
			  if (e.preventDefault) {
			    e.preventDefault(); // Necessary. Allows us to drop.
			  }
			  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
			  return false;
			}

			function handleDragEnter(e) {
			  // this / e.target is the current hover target.
			  this.classList.add('over');
			}

			function handleDragLeave(e) {
				var rect = this.getBoundingClientRect();
	           // Check the mouseEvent coordinates are outside of the rectangle
	           if(e.x > rect.left + rect.width || e.x < rect.left
	           || e.y > rect.top + rect.height || e.y < rect.top) {
	               this.classList.remove('over');  // this / e.target is previous target element.
	           }
			}

			function handleDrop(e) {
			  // this / e.target is current target element.
			  if (e.stopPropagation) {
			    e.stopPropagation(); // stops the browser from redirecting.
			  }
			  // Don't do anything if dropping the same column we're dragging.
			  if (dragSrcEl != this) {
			    // Set the source column's HTML to the HTML of the column we dropped on.
			    dragSrcEl.innerHTML = this.innerHTML;
			    this.innerHTML = e.dataTransfer.getData('text/html');
			    reorderImages();
			  }
			  // See the section on the DataTransfer object.
			  return false;
			}

			function handleDragEnd(e) {
			  // this/e.target is the source node.
			  this.style.opacity = '1';
			  [].forEach.call(cols, function (col) {
			    col.classList.remove('over');
			  });
			}

			var dragSrcEl = null;

			function handleDragStart(e) {
			  // Target (this) element is the source node.
			  this.style.opacity = '0.4';
			  dragSrcEl = this;
			  e.dataTransfer.effectAllowed = 'move';
			  e.dataTransfer.setData('text/html', this.innerHTML);
			}

			var cols = document.querySelectorAll('#droppable .image-entry');
			[].forEach.call(cols, function(col) {
			  col.addEventListener('dragstart', handleDragStart, false);
			  col.addEventListener('dragenter', handleDragEnter, false);
			  col.addEventListener('dragover', handleDragOver, false);
			  col.addEventListener('dragleave', handleDragLeave, false);
			  col.addEventListener('drop', handleDrop, false);
	  		  col.addEventListener('dragend', handleDragEnd, false);
			});
		}else{
			  jQuery( "#droppable" ).sortable({
			  	opacity: 0.4, 
			    cursor: 'move',
			    update: function(event, ui) {
			    	reorderImages()
			    }
			  });
		}







   /* 
 * Function to upload media
 */

 // Uploading files
            var file_frame;

            jQuery( '.multiimageupload').click(function( event ) {
            	alert('dfsd');

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php echo __( "Choose an image", "yith_wc_product_vendors" ) ?>',
                    button: {
                        text: '<?php echo __( "Use image", "yith_wc_product_vendors" ) ?>',
                    },
                    multiple: true
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {

                    var selection = file_frame.state().get('selection').toJSON();

                    attachment = file_frame.state().get('selection').first().toJSON();
               
                    jQuery('.id_img').val( attachment.id );
                    jQuery('.image-entry img').attr('src', attachment.sizes.thumbnail.url );
                    console.log(file_frame.state().get('selection'));
                    console.log(attachment.id);
                    console.log(attachment.sizes.thumbnail.url);
                    //jQuery('.{$remove_image_button}').show();
                });

                // Finally, open the modal.
                file_frame.open();
            });













	});</script>
	<style type="text/css">
	[draggable] {
	  -moz-user-select: none;
	  -khtml-user-select: none;
	  -webkit-user-select: none;
	  user-select: none;
	}
	.img-preview{
		position:relative;
		display:block;
		width:100px;
		height:100px;
		background:#efefef;
		border:1px solid #FFF;
	}
	.img-preview img{
		position:absolute;
		top:0;
		left:0;
	}
	.image-entry{
		float:left;
		margin:0 10px 10px 0;
		border:2px solid #ccc;
		padding:10px;
		background:#FFF;
	}
	.image-entry:last-child{margin-right:0;}
	.image-entry.over{
		border: 2px dashed #000;
	}
	.get-image,.del-image{
		margin-top:10px !important;
		display:block !important;
	}
	</style>
	<?php
}

/**
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 5. PROCEDURAL FUNCTIONS ↓
* @uses get_images_ids (FUNCTION) to retrieve linked images IDs
* @param thumbnail (BOOL) if true, prepend the thumbnail image Id of the current post at the front of the returned array
* @param id (INT) if defined, set the target post id
* @return ARRAY

* @uses get_images_src (FUNCTION) to retrieve linked images sources an dimentions
* @param size (STRING) the queried size
* @param thumbnail (BOOL) if true, prepend thumbnail image source of the current post at the front of the returned array
* @param id (INT) if defined, set the target post id
* @return ARRAY

* @uses get_multi_images_src (FUNCTION) to retrieve linked images IDs
* @param small (STRING) the first queried size
* @param large (STRING) the second queried size
* @param thumbnail (BOOL) if true, prepend thumbnail image sources of the current post at the front of the returned array
* @param id (INT) if defined, set the target post id
* @return ARRAY
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
function get_images_ids($thumbnail = false, $id = false){
	global $post;
	$the_id = ($id) ? $id : $post->ID;

	$list_images = list_my_images_slots( get_post_type( $id ) );

	$a = array();
	foreach ($list_images as $key => $img) {
		if($i = get_post_meta($the_id,$img,true))
			$a[$key] = $i;
	}
	if($thumbnail){
		$thumb_id = get_post_thumbnail_id($the_id);
		if(!empty($thumb_id)) array_unshift($a, get_post_thumbnail_id($the_id));
	} 
	return $a;
}

function get_images_src($size = 'medium',$thumbnail = false, $id = false){
	if($id)
		$images = $thumbnail ? get_images_ids(true,$id) : get_images_ids(false,$id);
	else 
		$images = $thumbnail ? get_images_ids(true) : get_images_ids();
	$o = array();
	foreach($images as $k => $i)
		$o[$k] = wp_get_attachment_image_src($i, $size);
	return $o;
}

function get_multi_images_src($small = 'thumbnail',$large = 'full',$thumbnail = false, $id = false){
	if($id)
		$images = $thumbnail ? get_images_ids(true,$id) : get_images_ids(false,$id);
	else 
		$images = $thumbnail ? get_images_ids(true) : get_images_ids();
	$o = array();
	foreach($images as $k => $i)
		$o[$k] = array(wp_get_attachment_image_src($i, $small),wp_get_attachment_image_src($i, $large));
	return $o;
}