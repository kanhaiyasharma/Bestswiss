<?php 
class adminUserdetail
{
	function test()
	{

		add_action('parent_file', 'menu_correction');
	    function menu_correction($parent_file) 
	    {
	    	global $current_screen,$pagenow;
	 	$taxonomy = $current_screen->taxonomy;
	 	$post_type = $current_screen->post_type;

	 	if($post_type == 'product')
	 	{
            if($pagenow == 'post.php')
            {
                $parent_file = 'edit.php?post_type='.$post_type;
            }

            if($pagenow == 'edit-tags.php')
            {
            	if( $taxonomy == 'bstregions' )
            	{
            		$parent_file = $pagenow.'?taxonomy='.$taxonomy.'&post_type='.$post_type;
            	}
            	if( $taxonomy == 'bstvencategory' )
		 		{
		 			$parent_file = $pagenow.'?taxonomy='.$taxonomy.'&post_type='.$post_type;
		 		}
		 		if( $taxonomy == 'yith_shop_vendor') 
		 		{
		 			$parent_file = $pagenow.'?taxonomy='.$taxonomy.'&post_type='.$post_type;
		 		}
            }
        }
        return $parent_file;
		}

		
		/* Add column title to Vendors*/
		add_filter ( 'manage_edit-yith_shop_vendor_columns','add_columns_title');
		function add_columns_title( $columns ) 
		{
			$columns['modified']	= 'Last Modified';
			$columns['Vendor of week']	= 'Vendor of week';
			return $columns;
		}

		/* Add column title to Products*/
		add_filter ( 'manage_edit-product_columns','add_column_title');
		function add_column_title( $columns ) 
		{
			$columns['product']	= 'Product of Week';
			return $columns;
		}

		/* manage last modified content(date & User) */
		add_filter("manage_yith_shop_vendor_custom_column", 'manage_columns_content', 10, 2);
		function manage_columns_content( $column_name, $post_id )
		{
			if($post_id == 'modified')
			{
				$latest = new WP_Query(
			        array(
			            'post_type' => 'product',
			            'orderby' => 'modified',
			            'order' => 'ASC'
			        )
			    );
			    if($latest->have_posts())
			    {
					foreach ($latest->posts as $key => $value) 
					{
						$post_modified = $value->post_modified_gmt;
		        	}
		        	$modified_date = mysql2date( 'd/m/Y', $post_modified );
	    		}
				$current_user = wp_get_current_user();
			    $user_id	= $current_user->ID ;
			    $user_info = get_userdata( $user_id );
			
			    echo '<p class="mod-date">' . $modified_date. ' by <strong>' . $user_info->display_name . '</strong></p>';
			}
		}

		/* manage column content for vender of week */
		add_filter('manage_yith_shop_vendor_custom_column','manage_product_type_columns', 10, 3); 
		function manage_product_type_columns( $content,$column_name,$term_id )
		{
			global $wpdb;
			if ($column_name == "Vendor of week")
			{
				$option_name = '_vendor_of_week';
				$check = get_option($option_name);
				?>
				<input type="radio" name="bst_vendor_of_week" id="vendor_<?php echo $term_id;?>" value="<?php echo $term_id;?>"
				<?php 
				if($check == $term_id) echo 'checked="checked"';
				?> >
				<?php
			}
		}

		/* manage column content for product of week */
		add_filter("manage_product_posts_custom_column", 'my_manage_product_columns', 10, 2);
		function my_manage_product_columns( $column_name, $post_id )
		{
			global $post;
			if ($column_name == "product")
			{
				?>
				<input type="radio" name="product[]" class="radio" id="product_<?php echo $post_id;?>" <?php 

				$option_name = '_product_of_week';
				$check = get_option($option_name);
				if($check == $post->ID) echo 'checked="checked"'; 
		        ?> disabled/>
		        <?php
			}
		}

		/* add meta box for Product of Week*/
		add_action( 'add_meta_boxes', 'productWeek_add_meta_boxes' );
		function productWeek_add_meta_boxes()
		{
			add_meta_box(
			'meta-box-product-id', 
			esc_html__( 'Product of the Week', 'example' ),  
			'cd_meta_box_cb',//call back function
			'product', 
			'side',
			'default' );
		}

		//call back function
		function cd_meta_box_cb()
		{
			global $post;
		    $values = get_post_custom( $post->ID );
		    $text = isset( $values['my_meta_box_text'] ) ? $values['my_meta_box_text'] : '';
		    $selected = isset( $values['my_meta_box_select'] ) ? esc_attr( $values['my_meta_box_select'] ) : '';
		    $check = isset( $values['my_meta_box_check'] ) ? esc_attr( $values['my_meta_box_check'] ) : '';
		     
		    //use this nonce field later on when saving.
		    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
		    ?>
		    <p>
		        <input type="checkbox" id="my_meta_box_check" name="my_meta_box_check" <?php
		        $option_name = '_product_of_week';
				$check = get_option($option_name);
				if($check == $post->ID) echo 'checked="checked"'; 
		         ?> />
		        <label for="my_meta_box_check">check this to make Product of Week</label>
		    </p>
		    <?php    
		}

		/* Save meta box content for Product of Week*/
		add_action( 'save_post', 'productWeek_meta_box_save', 10, 2 );
		function productWeek_meta_box_save( $post_id )
		{
			global $wpdb;
			$option_name = '_product_of_week';

			// Bail if we're doing an auto save
		    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		     
		    // if our nonce isn't there, or we can't verify it, bail
		    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
		     
		    // if our current user can't edit this post, bail
		    if( !current_user_can( 'edit_post' ) ) return;

			if( !update_option($option_name, $post_id))
			{
		    	add_option( $option_name, $post_id);
				return false;
		    }
		}

		/* Change css for Description column of yith_shop_vendor taxonomy */
		add_action('admin_head', 'yith_shop_vendor_excerpt_textarea_height');
		function yith_shop_vendor_excerpt_textarea_height() 
		{ 
			echo
			'<style type="text/css">
	        .wp-tab-panel, 
				.taxonomy-yith_shop_vendor 
	                #description{ height:500px; }
	        </style>
	        ';
		}

		/* add bulk actions for vendor of week */
		add_action('admin_footer-edit-tags.php', 'add_bulk_vendor_actions');
		function add_bulk_vendor_actions()
		{
			  	global $post_type,$pagenow;
		
				if($post_type == 'product') 
				{
	    	?>

		    <script type="text/javascript">	
		    jQuery(document).ready(function() 
		    {
		    	if(jQuery('#bulk-action-selector-top').length)
		      	{
		      		jQuery('#bulk-action-selector-top').append(jQuery('<option>', {
		    			value: 'vendor',
		    			text: 'Vendor of Week'
					}));
		      	}
		    });

		    </script>

		    <?php
			}
		}

		/* add actions i.e. save or update for vendor of week */
		add_action('load-edit-tags.php', 'vendor_bulk_action');
		function vendor_bulk_action( ) 
		{        
			global $wpdb;
			$option_name = '_vendor_of_week';

			$wp_list_table = _get_list_table('WP_Posts_List_Table');
  			$action = $wp_list_table->current_action();

		 	switch($action) 
		 	{
			    // Perform the action
			    case 'vendor':
			
			    $term_id = $_POST['bst_vendor_of_week'];

					if( !update_option($option_name, $term_id))
					{
				    	add_option( $option_name, $term_id);
						return false;
				    }
				
				// build the redirect url
				$sendback = $_SERVER['HTTP_REFERER'];
			    break;
			    default: return;
			}

		  // Redirect 
		  wp_redirect( $sendback );
		  exit();
		}
	}
}
?>