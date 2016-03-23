<?php
/** FUNCTIONS.PHP / TIMO OELERICH

INHALT

01 NAVIGATION REGISTRIEREN
02 SIDEBARS REGISTRIEREN
03 REMOVE EMOJI
04 REMOVE WLWMANIFEST
05 BREADCRUMB IN FOOTER
06 BILDER
07 ANREISSER
08 CHECK IF SIDEBAR IS ACTIVE
09 KILL ADMIN-BAR CSS
10 WOOCOMMERCE SUPPORT
11 KATEGORIE-LISTING
12 REMOVE ADD-TO-CART VON ARCHIVE-SEITEN
13 WÄHRUNG VON ARCHIV / SUCHE / KATEGORIE ENTFERNEN 
14 PAGE TITLE OVERRIDE
15 REMOVE BREADCRUMB IN WOO

**/


/** 01 NAVIGATION REGISTRIEREN **/
	function register_my_menus() {
  	register_nav_menus(
    	array(
			'main' => __( 'Hauptnavigation' )
		)
  	);}
	add_action( 'init', 'register_my_menus' );

/** 02 SIDEBARS REGISTRIEREN **/
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'left',
			'description' => 'Sidebar Links',
			'before_widget' => '<div class="widgetwrap">',
			'after_widget' => '</div>',
			'before_title' => ' <h3>',
			'after_title' => '</h3> '));
		
		register_sidebar(array(
			'name' => 'right',
			'description' => 'Sidebar Rechts',
			'before_widget' => '<div class="widgetwrap">',
			'after_widget' => '</div>',
			'before_title' => ' <h3>',
			'after_title' => '</h3> '));
			
		register_sidebar(array(
			'name' => 'Footer 1',
			'description' => 'Footer 1',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => ' <h4>',
			'after_title' => '</h4> '));	
			
		register_sidebar(array(
			'name' => 'Footer 2',
			'description' => 'Footer 2',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => ' <h4>',
			'after_title' => '</h4> '));	
			
		register_sidebar(array(
			'name' => 'Footer 3',
			'description' => 'Footer 3',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => ' <h4>',
			'after_title' => '</h4> '));	
			
		register_sidebar(array(
			'name' => 'copyright',
			'description' => 'Copyright',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => ''));		
	}
			
/** 03 REMOVE EMOJI **/
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );  

/** 04 REMOVE WLWMANIFEST **/
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');

/** 05 BREADCRUMB IN FOOTER **/
	function nav_breadcrumb() {
 
	$delimiter = '>';
 	$home = 'Bestswiss'; 
 	$before = '<span class="current-page">'; 
 	$after = '</span>'; 
 
 	if ( !is_home() && !is_front_page() || is_paged() ) {
 
 	echo '<nav class="breadcrumb">';
 
 	global $post;
 	$homeLink = get_bloginfo('url');
 	echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
 	if ( is_category()) {
 	global $wp_query;
 	$cat_obj = $wp_query->get_queried_object();
 	$thisCat = $cat_obj->term_id;
 	$thisCat = get_category($thisCat);
 	$parentCat = get_category($thisCat->parent);
 	if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
 	echo $before . single_cat_title('', false) . $after;
 
 	} elseif ( is_day() ) {
 	echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
 	echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
 	echo $before . get_the_time('d') . $after;
 
 	} elseif ( is_month() ) {
 	echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
 	echo $before . get_the_time('F') . $after;
 
 	} elseif ( is_year() ) {
 	echo $before . get_the_time('Y') . $after;
 
 	} elseif ( is_single() && !is_attachment() ) {
 	if ( get_post_type() != 'post' ) {
 	$post_type = get_post_type_object(get_post_type());
 	$slug = $post_type->rewrite;
 	echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
 	echo $before . get_the_title() . $after;
 	} else {
 	$cat = get_the_category(); $cat = $cat[0];
 	echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
 	echo $before . get_the_title() . $after;
 	}
 
 	} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
 	$post_type = get_post_type_object(get_post_type());
 	echo $before . $post_type->labels->singular_name . $after;
 
 	} elseif ( is_attachment() ) {
 	$parent = get_post($post->post_parent);
 	$cat = get_the_category($parent->ID); $cat = $cat[0];
 	echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
 	echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
 	echo $before . get_the_title() . $after;
 
 	} elseif ( is_page() && !$post->post_parent ) {
 	echo $before . get_the_title() . $after;
 
 	} elseif ( is_page() && $post->post_parent ) {
 	$parent_id = $post->post_parent;
 	$breadcrumbs = array();
 	while ($parent_id) {
 	$page = get_page($parent_id);
 	$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
 	$parent_id = $page->post_parent;
 	}
 	$breadcrumbs = array_reverse($breadcrumbs);
 	foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
 	echo $before . get_the_title() . $after;
 
 	} elseif ( is_search() ) {
 	echo $before . 'Ergebnisse für Ihre Suche nach "' . get_search_query() . '"' . $after;
 
 	} elseif ( is_tag() ) {
 	echo $before . 'Beiträge mit dem Schlagwort "' . single_tag_title('', false) . '"' . $after;

 	} elseif ( is_tag() ) {
 	echo $before . 'Beiträge mit dem Schlagwort "' . single_tag_title('', false) . '"' . $after;

 	} elseif ( is_404() ) {
 	echo $before . 'Fehler 404' . $after;
 	}
 
 	if ( get_query_var('paged') ) {
 	if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
 	echo ': ' . __('Seite') . ' ' . get_query_var('paged');
 	if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
 	}
 
 	echo '</nav>';
 
 	} 
	} 

/** 06 BILDER **/
	add_theme_support( 'post-thumbnails' );

	/* BILDGROESSEN */
	update_option( 'thumbnail_size_h', 210 );
    update_option( 'thumbnail_size_w', 280 );
    update_option( 'medium_size_h', 0 );
    update_option( 'medium_size_w', 0 );
    update_option( 'large_size_h', 0 );
    update_option( 'large_size_w', 0 );

    
    /* THUMBAIL LINKS TO POST */
	function wpdocs_post_image_html( $html, $post_id, $post_image_id ) {
    $html = '<a href="' . get_permalink( $post_id ) . '" alt="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
    return $html;}
	add_filter( 'post_thumbnail_html', 'wpdocs_post_image_html', 10, 3 );
	
/** 07 ANREISSER / READ-MORE - TEXT VIA CSS CONTENT:AFTER **/	
	function new_excerpt_more($more) {
	return '...<span><a class="readmore" href="'. get_permalink($post->ID) . '">' . '' . '</a></span>';}
	add_filter('excerpt_more', 'new_excerpt_more');
	
	function new_excerpt_length( $length ) {
    return 30;}
	add_filter( 'excerpt_length', 'new_excerpt_length', 999 );

/** 08 CHECK IF SIDEBAR IS ACTIVE **/	
	function is_sidebar_active($index) {
    	global $wp_registered_sidebars;
    	$widgetcolums = wp_get_sidebars_widgets();
    	if ($widgetcolums[$index])
        	return true;
    	return false;}

/** 09 KILL ADMIN-BAR CSS **/	
	add_action('get_header', 'remove_admin_login_header');
	function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');} 
	
/** 10 WOOCOMMERCE SUPPORT **/
	add_action( 'after_setup_theme', 'woocommerce_support' );
		function woocommerce_support() {
    	add_theme_support( 'woocommerce' );}
    
    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
    	
/** 11 KATEGORIE-LISTING **/
	function order_by_multiple() {
		if(function_exists('is_woocommerce')){
			if(is_woocommerce()||is_search()||is_product_category())    return ' tm.meta_value, post_title';
			}}

/** 12 REMOVE ADD-TO-CART VON ARCHIVE-SEITEN **/
	function remove_loop_button(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );}
	add_action('init','remove_loop_button');

/** 13 WÄHRUNG VON ARCHIV / SUCHE / KATEGORIE ENTFERNEN 
	function remove_wc_currency_symbol( $currency_symbol, $currency ) {
		if (is_archive()||is_search()||is_product_category()) {
     		$currency_symbol = '';
     		return $currency_symbol;
		} else {
    		return $currency_symbol;
    	}}
	add_filter('woocommerce_currency_symbol', 'remove_wc_currency_symbol', 10, 2); **/

/** 14 PAGE TITLE **/
	function wc_custom_shop_archive_title( $title ) {
    	if ( is_shop() ) {
        	return str_replace( __( 'Products', 'woocommerce' ), 'Bestswiss | Shop', $title );}
			return $title;}
		add_filter( 'wp_title', 'wc_custom_shop_archive_title' );

/** REMOVE BREADCRUMB IN WOO **/
	function remove_woo_crumbs(){
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );}
	add_action('init','remove_woo_crumbs');

?>