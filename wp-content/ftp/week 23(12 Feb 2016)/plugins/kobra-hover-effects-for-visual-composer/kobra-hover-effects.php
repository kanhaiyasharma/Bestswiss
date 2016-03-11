<?php
/*
Plugin Name: Kobra Hover Effects for Visual Composer
Plugin URI: http://wpexpert24.com/
Description: Kobra Hover Effects WordPress is an Visual Composer Plugin is an impressive Image hover effects powered by pure CSS3.
Author: Rakibur Rahman Sagar
Author URI: http://wpexpert24.com/
Version: 1.2
*/

	// Calling CSS
          wp_register_style('style_common', plugins_url('css/style_common.css', __FILE__));
          wp_enqueue_style('style_common');
		  
		 wp_register_style('main-style', plugins_url('css/main-style.css', __FILE__));
          wp_enqueue_style('main-style');	
		  
		 wp_register_style('vc-responsive-hover', plugins_url('css/vc-responsive-hover.css', __FILE__));
          wp_enqueue_style('vc-responsive-hover');
		  
		 wp_register_style('style-new-hov', plugins_url('css/style-new-hov.css', __FILE__));
          wp_enqueue_style('style-new-hov');

 if(!class_exists('org_hov')) {
	 class org_hov {

	 
	 function __construct() {
			
			add_shortcode("org_hov",array($this,"org_hov_callback"));
			add_shortcode("org_hov_item",array($this,"org_hover_item_callback"));
			
			add_action( 'init', array( $this, 'your_name_integrateWithVC' ) );
			
		}
		
// Container Shortcode
		function org_hov_callback($atts, $content = null){

		   $output = '';
		  
		  extract( shortcode_atts( array(
		  
				  
			  ), $atts ) );
			  
		  $content = wpb_js_remove_wpautop($content, true);
		  		  


		  $output 	.= 	' <div class="main">';
		  $output 	.= 			do_shortcode($content); 
		  $output 	.= 	'</div>';
		  
		  return $output;
		}
		  
// Item Shortcode		
		function org_hover_item_callback($atts, $content = null){
			
		 $style = $images = $text1  = $itemOutput = '';
		  extract( shortcode_atts( array(
				  'title' 		=>	'',
				  'style' 		=>	'style1',
				  'descript' 		=>	'',
				  'images' 		=>	'',
				  'link' 		=>	'',
				  'button_choser' 		=>	'btn-default',
				  'showing_item' 		=>	'col-lg-12 col-md-12 col-sm-12 col-xs-12',
			  ), $atts ) );
		 $content = wpb_js_remove_wpautop($content, true);
		  $images = wp_get_attachment_image_src($images, 'full');
		 $link = vc_build_link($link);

		 if  ($style == 'style1') {
		 $itemOutput .= '
		 <div class="'.$showing_item.'">
		 <div style="border: 10px solid #FFFFFF;" class="vc_view view-first">
                    <img src="'.$images[0].'" />
                    <div style="background-color:rgb(26, 188, 156,0.8);" class="vcmask">
                        <h2 >'.$title.'</h2>
                        <p>'.$descript.'</p>
                       <a style="color: #fff;" class="btn '.$button_choser.'" href="'.$link['url'].'" target="'.$link['target'].'">'.$link['title'].' </a>
                    </div></div></div>';
		 }
	 
		 if  ($style == 'style2') {
		 $itemOutput .= '
		 <div class="'.$showing_item.'">
		 <div class="vc_view view-second">
                    <img src="'.$images[0].'" />
                     <div style="background-color:rgb(230, 126, 34,0.5);" class="vcmask">
                        <h2 >'.$title.'</h2>
                        <p>'.$descript.'</p>
                        <a style="color: #fff;" class="btn '.$button_choser.'" href="'.$link['url'].'" target="'.$link['target'].'" >'.$link['title'].' </a>
                    </div></div></div>';
		 }
		 if  ($style == 'style3') {
		 $itemOutput .= '
		  <div class="'.$showing_item.'">
		 <div class="vc_view view-third">
                    <img src="'.$images[0].'" />
                     <div style="background-color:rgb(142, 68, 173,0.8);" class="vcmask">
                        <h2>'.$title.'</h2>
                        <p>'.$descript.'</p>
                         <a style="color: #fff;" class="btn '.$button_choser.'" href="'.$link['url'].'" target="'.$link['target'].'" >'.$link['title'].' </a>
                    </div></div></div>';
		 }
		 if  ($style == 'style4') {
		 $itemOutput .= '
		  <div class="'.$showing_item.'">
		 <div class="vc_view view-fourth">
                    <img src="'.$images[0].'" />
                     <div style="background-color:rgb(44, 62, 80);" class="vcmask">
                        <h2>'.$title.'</h2>
                        <p>'.$descript.'</p>
                          <a style="color: #fff;" class="btn '.$button_choser.'" href="'.$link['url'].'" target="'.$link['target'].'" >'.$link['title'].' </a>
                    </div></div></div>';
		 }
		 if  ($style == 'style5') {
		 $itemOutput .= '
		  <div class="'.$showing_item.'">
		 <div class="vc_view view-fifth">
                    <img src="'.$images[0].'" />
                     <div style="background-color:rgb(39, 174, 96);" class="vcmask">
                        <h2>'.$title.'</h2>
                        <p>'.$descript.'</p>
                          <a style="color: #fff;" class="btn '.$button_choser.'" href="'.$link['url'].'" target="'.$link['target'].'" >'.$link['title'].' </a>
                    </div></div></div>';
		 }
		 
		 if ($style == 'style6') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style7') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style8') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style9') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style10') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style11') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style12') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="#">Click Here </a></h3>';
		 }
		 if ($style == 'style13') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style14') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style15') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style16') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style17') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
		 if ($style == 'style18') {
			$itemOutput .= ' <h3> This Style Only For Pro Version. To Get Pro Version <a href="http://wpexpert24.com/kobra-hover-effects-for-visual-composer-pro/">Click Here </a></h3>';
		 }
			return $itemOutput;
		}		
		
			function your_name_integrateWithVC() {
			  //Register "container" content element. It will hold all your inner (child) content elements
			  if(function_exists("vc_map")){

				  vc_map( array(
					  "name" => __("Kobra Hover Effects", "ultimate_vc"),
					  "base" => "org_hov",
					  "as_parent" => array('only' => 'org_hov_item'),
					  "content_element" => true,
					  "show_settings_on_create" => true,
					  "category" => 'Kobra Hov',
					  "icon" => "ult_ihover",
					  "class" => "ult_ihover",
					  "description" => __("Image hover effects with information.","ultimate_vc"),
					  "js_view" => 'VcColumnView'
				  ) );
	  
				  vc_map( array(
					  "name" => __("Kobra Hover Effects", "ultimate_vc"),
					  "base" => "org_hov_item",
					  "content_element" => true,
					  "icon" => "ult_ihover",
					  "class" => "ult_ihover",
					  "as_child" => array('only' => 'org_hov'), // Use only|except attributes to limit parent (separate multiple values with comma)
					  "is_container"    => false,
					  "params" => array(
					  
// General Settings
// Attached Image Field	
					  
              array(
                "type" => "attach_image",
                "heading" => __("Upload Image", "ultimate_vc"),
                "param_name" => "images",
                "value" => "",
                "description" => __("Select images from media library.", "ultimate_vc")
              ),

						  
// Select Style Field
								array(
								  "type"        => "dropdown",
								  "heading"     => __("Select Style"),
								  "param_name"  => "style",
								  "admin_label" => true,
								  "value"       => array(
									'Style 1'   => 'style1',
									'Style 2'   => 'style2',
									'Style 3'   => 'style3',
									'Style 4'   => 'style4',
									'Style 5'   => 'style5',
									'Style 6 - pro Only'   => 'style6',
									'Style 7 - pro Only'   => 'style7',
									'Style 8 - pro Only'   => 'style8',
									'Style 9 - pro Only'   => 'style9',
									'Style 10 - pro Only'   => 'style10',
									'Style 11 - pro Only'   => 'style11',
									'Style 12 - pro Only'   => 'style12',
									'Style 13 - pro Only'   => 'style13',
									'Style 14 - pro Only'   => 'style14',
									'Style 15 - pro Only'   => 'style15',
									'Style 16 - pro Only'   => 'style16',
									'Style 17 - pro Only'   => 'style17',
									'Style 18 - pro Only'   => 'style18',

								  ),
						    ),
						
													  
// Select Style Field
								array(
								  "type"        => "dropdown",
								  "heading"     => __("Hover Item in 1 row"),
								  "param_name"  => "showing_item",
								  "admin_label" => true,
								  "value"       => array(
									'Show 1 Item in 1 row'   => 'col-lg-12 col-md-12 col-sm-12 col-xs-12',
									'Show 2 Item in 1 row'   => 'col-lg-6 col-md-6 col-sm-6 col-xs-12',
									'Show 3 Item in 1 row'   => 'col-lg-4 col-md-4 col-sm-6 col-xs-12',
									'Show 4 Item in 1 row'   => 'col-lg-3 col-md-3 col-sm-6 col-xs-12',
								  ),
						    ),
							
// Title Field 
						  array(
							  "type" => "textfield",
							  /*"holder" => "div",*/
							  "class" => "",
							  "heading" => __("Title", 'ultimate_vc'),
							  "param_name" => "title",
							  "admin_label" => true,
							  "value" => "",
							  /*"description" => __("Provide the title for the iHover.", 'ultimate')*/
						  ),
						  
// Description Field	
					  
						array(
							  "type" => "textarea",
							  /*"holder" => "div",*/
							  "class" => "",
							  "heading" => __("Description", 'ultimate_vc'),
							  "param_name" => "descript",
							  "admin_label" => true,
							  "value" => "",
							  /*"description" => __("Provide the title for the iHover.", 'ultimate')*/
						  ),

							
// Link Field 
						  array(
							  "type" => "vc_link",
							  "class" => "",
							  "heading" => __("URL (Link)", 'ultimate_vc'),
							  "param_name" => "link",
							  "description" => __("Provide the link here.", 'ultimate_vc')
						  ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "ultimate_vc",
                "heading" => __("Chose Button", "ultimate_vc"),
                "param_name" => "button_choser",
                "value" => array( __("Default", "ultimate_vc") => "btn-default", __("Primary", "ultimate_vc") => "btn-primary", __("Success", "ultimate_vc") => "btn-success", __("Info", "ultimate_vc") => "btn-info", __("Warning", "ultimate_vc") => "btn-warning",  __("Danger", "ultimate_vc") => "btn-danger",  __("Link", "ultimate_vc") => "btn-link"),
                "description" => __("Select the Different Type of button", "ultimate_vc")
              ),					  
				  

				  // Background Color
				  			  
			           array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "Item Background color - <span style='color: red;'>Pro Only</span>", "my-text-domain" ),
            "param_name" => "bg_color",
            "value" => '#FF0000', //Default Red color
            "description" => __( "This Option Works only With Pro Version", "my-text-domain" )
         ),
		 
		 // Title Font Size Field	
						  array(
							  "type" => "textfield",
							  "class" => "",
							  "heading" => __("Title Text Size - <span style='color: red;'>Pro Only</span>", 'ultimate_vc'),
							  "param_name" => "title_size",
							  "admin_label" => true,
							  "value" => "20",
							   "description" => __( "This Option Works only With Pro Version", "my-text-domain" )
						  ),
						  
		 // Tilte Color
				  			  
			           array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "Title Text color -<span style='color: red;'>Pro Only</span>", "my-text-domain" ),
            "param_name" => "title_color",
            "value" => '#FFFFFF', //Default Red color
            "description" => __( "This Option Works only With Pro Version", "my-text-domain" )
         ),		 
		 // Description Font Size Field	
						  array(
							  "type" => "textfield",
							  "class" => "",
							  "heading" => __("Description Text Size - <span style='color: red;'>Pro Only</span>", 'ultimate_vc'),
							  "param_name" => "desc_size",
							  "admin_label" => true,
							  "value" => "15",
							   "description" => __( "This Option Works only With Pro Version", "my-text-domain" )
						  ),
						  
		 // Description Color
				  			  
			           array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "Description Text color - <span style='color: red;'>Pro Only</span>", "my-text-domain" ),
            "param_name" => "desc_color",
            "value" => '#FFFFFF', //Default Red color
            "description" => __( "This Option Works only With Pro Version", "my-text-domain" )
         ),	 
		 
		 // Button Font Size 
						  array(
							  "type" => "textfield",
							  "class" => "",
							  "heading" => __("Button Text Size - <span style='color: red;'>Pro Only</span>", 'ultimate_vc'),
							  "param_name" => "Button_size",
							  "admin_label" => true,
							  "value" => "12",
							   "description" => __( "This Option Works only With Pro Version", "my-text-domain" )
						  ),
						  
		 // Button Text Color
				  			  
			           array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "Button Text color - <span style='color: red;'>Pro Only</span>", "my-text-domain" ),
            "param_name" => "button_color",
            "value" => '#FFFFFF', //Default Red color
            "description" => __( "This Option Works only With Pro Version", "my-text-domain" )
         ),
		 
						  
						  
						  
					  )
				  ) );
			  }
		} 



	}	


		// Finally initialize code
			new org_hov;
			
			  if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
					  class WPBakeryShortCode_org_hov extends WPBakeryShortCodesContainer {
				  }
			  }
			  if ( class_exists( 'WPBakeryShortCode' ) ) {
					  class WPBakeryShortCode_org_hov_item extends WPBakeryShortCode {
				  }
			  }
			  
}			
			
			
			
			
?>