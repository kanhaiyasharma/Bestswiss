<?php
/**
 * @package Bst_Manufacture
 * @version 1.0
 */
/*
Plugin Name: Manage Manufacturer
Plugin URI: #
Description: #
Author: #
Version: 1.0
Author URI: #
*/

function __p($arg){
	echo "<pre>";
	print_r($arg);
	echo "</pre>";
}


//add_action( 'wp_loaded', 'change_product_yith_shop_vendor_labels',  20 );
function change_product_yith_shop_vendor_labels()
{
    global $wp_taxonomies;
    
    if($wp_taxonomies['yith_shop_vendor']->labels->name == 'Vendor'){
    	$wp_taxonomies['yith_shop_vendor']->labels->name = 'Manufacturers';
    	$wp_taxonomies['yith_shop_vendor']->label = 'Manufacturer';
    	$wp_taxonomies['yith_shop_vendor']->labels->menu_name = 'Manufacturers';
    	$wp_taxonomies['yith_shop_vendor']->labels->singular_name = 'Manufacturer';
    	$wp_taxonomies['yith_shop_vendor']->labels->search_items = 'Search Manufacturers';
    	$wp_taxonomies['yith_shop_vendor']->labels->all_items = 'All Manufacturers';
        $wp_taxonomies['yith_shop_vendor']->labels->parent_item = 'Parent Manufacturer';
        $wp_taxonomies['yith_shop_vendor']->labels->parent_item_colon = 'Parent Manufacturer:';
        $wp_taxonomies['yith_shop_vendor']->labels->view_item = 'View Manufacturer';
        $wp_taxonomies['yith_shop_vendor']->labels->update_item = 'Update Manufacturer';
        $wp_taxonomies['yith_shop_vendor']->labels->add_new_item = 'Add New Manufacturer';
        $wp_taxonomies['yith_shop_vendor']->labels->new_item_name = 'New Manufacturers';
        $wp_taxonomies['yith_shop_vendor']->labels->archives = 'All Manufacturers';




    }
    
}





function yith_shop_vendor_taxonomy_add_new_meta_field() {
	// this will add the custom meta field to the add new term page
  
	?>
	<!-- <div class="form-field">
		<label for="term_meta[custom_term_meta]"><?php _e( 'Example meta field', 'pippin' ); ?></label>
		<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">
		<p class="description"><?php _e( 'Enter a value for this field','pippin' ); ?></p>
	</div> -->
<?php
}
add_action( 'yith_shop_vendor_add_form_fields', 'yith_shop_vendor_taxonomy_add_new_meta_field', 10, 1 );


function add_custom_rewrite_rule() {

    // First, try to load up the rewrite rules. We do this just in case
    // the default permalink structure is being used.
    if( ($current_rules = get_option('rewrite_rules')) ) {

        // Next, iterate through each custom rule adding a new rule
        // that replaces 'movies' with 'films' and give it a higher
        // priority than the existing rule.
        foreach($current_rules as $key => $val) {
            if(strpos($key, 'vendor') !== false) {

            
           flush_rewrite_rules();
            add_rewrite_rule(str_ireplace('vendor', 'manufacturer', $key), $val, 'top');   

            
                
            } // end if
        } // end foreach
        

    } // end if/else

} // end add_custom_rewrite_rule
add_action('init', 'add_custom_rewrite_rule',10,0);





/*
 * Actions on activation
 */

function bst_setup_post_type() {
 
    // Register our "book" custom post type
    $labels = array(
        'name'              => _x( 'Regions', 'taxonomy general name' ),
        'singular_name'     => _x( 'Region', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Regions' ),
        'all_items'         => __( 'All Regions' ),
        'parent_item'       => __( 'Parent Region' ),
        'parent_item_colon' => __( 'Parent Region:' ),
        'edit_item'         => __( 'Edit Region' ),
        'update_item'       => __( 'Update Region' ),
        'add_new_item'      => __( 'Add New Regions' ),
        'new_item_name'     => __( 'New Region Name' ),
        'menu_name'         => __( 'Regions' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_menu'      => false,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'bestwishregions' ),
    );
    register_taxonomy( 'bstregions', array( 'product' ), $args );

    wp_insert_term( 'Zurich', 'bstregions', $args = array() );
    wp_insert_term( 'The Bernese Oberland', 'bstregions', $args = array() );
    wp_insert_term( 'Northeastern Switzerland', 'bstregions', $args = array() );
    wp_insert_term( 'Basel & the Jura', 'bstregions', $args = array() );
    wp_insert_term( 'The Valais', 'bstregions', $args = array() );
    wp_insert_term( 'Lausanne & the Shores of Lake Geneva', 'bstregions', $args = array() );
    wp_insert_term( 'Geneva', 'bstregions', $args = array() );
    wp_insert_term( 'Lucerne & Central Switzerland', 'bstregions', $args = array() );
    wp_insert_term( 'The Grisons & the Engadine', 'bstregions', $args = array() );
    wp_insert_term( 'The Ticino', 'bstregions', $args = array() );


    /*
     * Vendor Snippets type
     *
     */

    $argspst =array('label'=>'Vendor snippets','show_in_menu'=>false,'show_in_nav_menus'=>false);
    register_post_type( 'vendorsnippet', $argspst );

    /*
     * Vendor regions
     *
     */

    // Register our "book" custom post type
    $labels = array(
        'name'              => _x( 'Vendor Category', 'taxonomy general name' ),
        'singular_name'     => _x( 'Vendor Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Vendor Categories' ),
        'all_items'         => __( 'All Vendor Categories' ),
        'parent_item'       => __( 'Parent Vendor Category' ),
        'parent_item_colon' => __( 'Parent Vendor Category:' ),
        'edit_item'         => __( 'Edit Vendor Category' ),
        'update_item'       => __( 'Update Vendor Category' ),
        'add_new_item'      => __( 'Add New Vendor Categories' ),
        'new_item_name'     => __( 'New Vendor Category' ),
        'menu_name'         => __( 'Vendor Category' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_menu'      => false,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'vcategory' ),
    );
    register_taxonomy( 'bstvencategory', array( 'product' ), $args );


 
}
add_action( 'init', 'bst_setup_post_type' );
 
function bst_install() {
 
    // Trigger our function that registers the custom post type
    bst_setup_post_type();
 
    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();
 
}
register_activation_hook( __FILE__, 'bst_install' );




function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Regions', 'textdomain' ),
        'Regions',
        'manage_options',
        'edit-tags.php?taxonomy=bstregions&post_type=product',
        '',
        '',
        5
    );

    add_menu_page(
        __( 'Vendor Category', 'textdomain' ),
        'Vendor Categories',
        'manage_options',
        'edit-tags.php?taxonomy=bstvencategory&post_type=product',
        '',
        '',
        5
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );





/*
 * Upload image
 *
 */


         function add_upload_field1( $wrapper = 'div', $image_id = '', $type = 'header_image',$label,$multiple ) {
          /* __p($wrapper);
           __p($image_id);
           __p($type);
            die;*/
            
            $image_id=($image_id==1)?'':$image_id;

            $args = array(
                'placeholder'           => empty( $image_id ) ? wc_placeholder_img_src() : wp_get_attachment_url( $image_id ),
                'image_wrapper_id'      => "yith_vendor_{$type}",
                'hidden_field_id'       => "yith_vendor_{$type}_id",
                'hidden_field_name'     => "yith_vendor_data[{$type}]",
                'upload_image_button'   => "upload_image_button_{$type}",
                'remove_image_button'   => "remove_image_button_{$type}",
                'wrapper'               => $wrapper,
                'image_id'              => $image_id,
                'Label'                 => $label,
                'multiple'              => $multiple
            );



            yith_wcpv_get_template1( 'taxonomy-upload-field', $args, 'admin' );


            add_upload_field_script1( $args );
        }

        /**
         * Add upload fields script
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         *
         * @return void
         * @use wc_enqueue_js
         */
         function add_upload_field_script1( $args ) {
            extract($args);
            // Only show the "remove image" button when needed
            $inline_script = "if ( ! jQuery('#{$hidden_field_id}').val() ) {
                jQuery('.{$remove_image_button}').hide();
            }

            // Uploading files
            var file_frame;

            jQuery( document ).on( 'click', '.{$upload_image_button}', function( event ) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '" . __( 'Choose an image', 'yith_wc_product_vendors' ) . "',
                    button: {
                        text: '" . __( 'Use image', 'yith_wc_product_vendors' ) . "',
                    },
                    multiple: ".$multiple."
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    attachment = file_frame.state().get('selection').first().toJSON();

                    jQuery('#{$hidden_field_id}').val( attachment.id );
                    jQuery('#{$image_wrapper_id} img').attr('src', attachment.sizes.thumbnail.url );
                    jQuery('.{$remove_image_button}').show();
                });

                // Finally, open the modal.
                file_frame.open();
            });

            jQuery( document ).on( 'click', '.{$remove_image_button}', function( event ) {
                jQuery('#{$image_wrapper_id} img').attr('src', '" . wc_placeholder_img_src('custom150x150') . "');
                jQuery('#{$hidden_field_id}').val('');
                jQuery('.{$remove_image_button}').hide();
                return false;
            });";

            wc_enqueue_js( $inline_script );
        }


        function yith_wcpv_get_template1( $filename, $args = array(), $section = '' ) {

        $ext           = strpos( $filename, '.php' ) === false ? '.php' : '';
        $template_name = $section . '/' . $filename . $ext;
        $template_path = WC()->template_path();

        $default_path  = YITH_WPV_TEMPLATE_PATH;


        if ( defined( 'YITH_WPV_PREMIUM' ) ) {
            $premium_template = str_replace( '.php', '-custom.php', $template_name );
             $located_premium  = wc_locate_template( $premium_template, $template_path, $default_path );
            $template_name    = file_exists( $located_premium ) ? $premium_template : $template_name;
        }

        wc_get_template( $template_name, $args, $template_path, $default_path );
    }



    add_image_size( 'custom150x150', 150, 150 );


    include_once('custom-meta.php');

    add_action('yith_shop_vendor_edit_form_fields', 'yith_shop_vendor_metabox_edit', 10, 1);    
    function yith_shop_vendor_metabox_edit($tgid){
         
         $meta_value = boilerclassp();
         //mtbox = new ADD_META_BOX1( $meta_b );
         $meta_value[0]['termetaid'] = $tgid->term_id;
         
         ?>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="Untertitel">Snippets</label></th>
                <td> 
                 <?php
                    
                    foreach( $meta_value as $meta_b )
                    {
                       $objMetabox = new ADD_META_BOX1( $meta_b );
                        $objMetabox->show();
                    }


                    ?>
                </td>
            </tr>

         <?php
    }



  add_action('edited_yith_shop_vendor', 'save_yith_shop_vendor_metadata', 10, 1);

  function save_yith_shop_vendor_metadata($term_id){

    $idval = $_POST['tag_ID'];
    $meta_value = boilerclassp();
    update_woocommerce_term_meta($idval,'Beschreibungeditor',$_POST['yith_vendor_data1']['Beschreibungeditor']);
    update_woocommerce_term_meta($idval,'regionto',$_POST['yith_vendor_data']['regionto']);

    foreach( $meta_value as $meta_b )
    {
      $metavlddd =  new ADD_META_BOX1( $meta_b );
      $metavlddd->save($idval);
    }
  }
?>