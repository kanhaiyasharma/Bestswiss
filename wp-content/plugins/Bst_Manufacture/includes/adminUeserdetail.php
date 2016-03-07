<?php

class adminUeserdetail{
	
   function menuHighlighter(){

   		add_action('parent_file', 'menu_correction');
	    function menu_correction($parent_file) 
	    {
		global $current_screen;
		$taxonomy = $current_screen->taxonomy;

			if ($taxonomy == 'bstregions' )
			{
				$parent_file = 'edit-tags.php?taxonomy=bstregions&post_type=product';
				return $parent_file;
			}
			if ($taxonomy == 'bstvencategory' )
			{
				$parent_file = 'edit-tags.php?taxonomy=bstvencategory&post_type=product';
				return $parent_file;
			}
			else 
			{
				$parent_file = 'edit.php';
				return $parent_file;
			}
		}

   	
   }


}


?>