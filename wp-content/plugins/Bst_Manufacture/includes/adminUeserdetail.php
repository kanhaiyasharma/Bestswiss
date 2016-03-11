<?php

class adminUeserdetail{
	
	/*
	* Function For highlighting Vendor Category,Vendor Region
	*/
   function menuHighlighter(){

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

   	
   }#End function

   function ShowLastmodifier()
	{
		/* Add column title */
		add_filter ( 'manage_edit-yith_shop_vendor_columns','add_columns_title');
		function add_columns_title( $columns ) 
		{
			$columns['modified']	= 'Last Modified';
			//$columns['Vendor of week']	= 'Vendor of week';
			return $columns;
		}

		/* manage last modified content(date & User) */
		add_filter("manage_yith_shop_vendor_custom_column", 'manage_columns_content', 10, 2); 
		function manage_columns_content( $column_name, $post_id )
		{
			
			if ($post_id == "modified")
			{

				$current_user = wp_get_current_user();
			    $user_id	= $current_user->ID ;
			    $user_info = get_userdata( $user_id );
			
			    echo '<p class="mod-date"><strong>' . ucfirst($user_info->display_name) . '</strong></p>';
			}
		}

		/* Change css for Last modified column */
		add_action('admin_head', 'modified_column_width');
		function modified_column_width() 
		{
		    /*echo 
		    '<style type="text/css">
		    .wp-tab-panel, 
				.taxonomy-yith_shop_vendor 
	                #modified{ text-align: center; width:140px; overflow:hidden }
		    </style>';*/
		}
	}#end function


}


?>