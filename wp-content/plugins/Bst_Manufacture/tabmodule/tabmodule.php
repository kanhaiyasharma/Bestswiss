<?php


function add_theme_scripts($hook) {
    global $post_type;

	if($post_type == 'product'){
		wp_enqueue_style( 'jqueryuicss', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css', array());
		//wp_enqueue_style( 'jqueryuicss', 'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array());

  		//wp_enqueue_script( 'jqueryminjs', 'http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js', array ( 'jquery' ), 1.1, true);
  		wp_enqueue_script( 'jqueryuimin', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js', array ( 'jquery' ), 1.1, true);

	}
 
}
add_action( 'admin_enqueue_scripts', 'add_theme_scripts' );

?>