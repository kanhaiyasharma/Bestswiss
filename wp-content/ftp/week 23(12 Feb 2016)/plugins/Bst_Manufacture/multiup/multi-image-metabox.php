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
		'image1' => '_image1'
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
                <td  class='gallerycontainer'> 
                 <?php
                    
                    $cpts = apply_filters('images_cpt', array('yith_shop_vendor'));
                    $screen = get_current_screen();

					/*foreach($cpts as $cpt){
						add_meta_box('imagesliees', __('Add Photos'), "imagesliees", null, 'normal', 'core');
					}*/

					imagesliees($tgid);


                    ?>
                    <div class='multicontainer'></div>
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


	$tagid = $post->term_id;
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
	wp_enqueue_style( 'customsimg-mb', plugin_dir_url().'Bst_Manufacture/css/multiup.css');
	wp_enqueue_style( 'thickbox' );

	wp_nonce_field( 'image-liee-save_'.$post->term_id, 'image-liee-nonce');

	
	$z =1;
	
	$imgstag = get_woocommerce_term_meta($tagid,'upimage',true);
	$imgaidrr = explode(',',$imgstag);

	foreach($imgaidrr as $k=>$i){
		$meta = $i;
		$no=$k+1;
		echo '<div id="droppable'.$no.'">';
		$img = (isset($meta)) ? '<img src="'.wp_get_attachment_thumb_url($meta).'" width="100" height="100" alt="" draggable="false">' : '';
		echo '<div class="image-entry" draggable="true">';
		echo '<input type="hidden" name="upimage[]" id="image'.$no.'" class="id_img" data-num="'.$no.'" value="'.$meta.'">';
		echo '<div class="img-preview" data-num="'.$no.'">'.$img.'</div>';
		$onl='';
		/*if($no != 1){*/ $onl='onclick="addImage()"'; /*}*/
		echo '<a '.$onl.' href="javascript:void(0);" class="multiimageupload" data-num="'.$no.'">'._x('Add New','file').'</a><a onclick="deletImage('.$meta.','.$no.')" href="javascript:void(0);" class="delbutton" data-num="'.$no.'">'.__('Delete').'</a>';
		echo '</div>';
		$z++;
		echo '</div>';
	}
	
	?>

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
            



});

function deletImage(id,divno){
	
	var total =jQuery('.delbutton').length;
   	if(total>1){
      jQuery("#droppable"+divno).remove();
   	}else if(total==1){
   		jQuery("#droppable"+divno+" img").attr('src','');
   	}
   }

function addImage(){
file_frame='';

	// event.preventDefault();

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

                    var selection = file_frame.state().get('selection');
                    var objselection = selection.toJSON();
                    k = jQuery('.cimage-entry').length;
                    
                   if(k==1 && jQuery('#droppable1 img').attr('src')==''){

                   	   

					  	   for (i = 0; i < objselection.length; i++) {
						    idval = objselection[i].id;
						    idurl = objselection[i].sizes.thumbnail.url;
                            k=k+1;
					    	divcontain1 = "<div  class='cimage-entry'><input type='hidden' value='"+idval+"' data-num='"+idval+"' class='id_img' id='image1' name='upimage[]'><div data-num='"+idval+"' class='img-preview'><img height='100' width='100' draggable='false' alt='' src='"+idurl+"'></div><a onclick='addImage()' data-num='1' class='multiimageupload' href='javascript:void(0);''>Add New</a><a data-num='1' class='delbutton' href='javascript:void(0);' onclick='deletImage("+idval+",1)'>Delete</a></div>";  
                           jQuery('.gallerycontainer #droppable1').html(divcontain1);
					    }

					  

                   }
                   else{

                    for (i = 0; i < objselection.length; i++) {
					    idval = objselection[i].id;
					    idurl = objselection[i].sizes.thumbnail.url;

					    
                            k=k+1;
					    	divcontain = "<div id='droppable"+k+"' class=''><div class='cimage-entry'><input type='hidden' value='"+idval+"' data-num='"+k+"' class='id_img_c' id='image"+k+"' name='upimage[]'><div data-num='"+k+"' class='img-preview'><img height='100' width='100' alt='' src='"+idurl+"'></div><a data-num='"+idval+"' class='multiimageupload' href='javascript:void(0);' onclick='addImage()'>Add New</a><a data-num='"+k+"' class='delbutton' onclick='deletImage("+idval+","+k+")' href='javascript:void(0);'>Delete</a></div></div> ";
                           jQuery('.multicontainer').append(divcontain);
					    
					}
				   }
 
                });

                // Finally, open the modal.
                file_frame.open();

}   


</script>

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