<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<style>.shopcurrent a {color: #cea951!important;}</style>

<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div id="shop">
<?php
  $objtax =get_queried_object();
  $termid =$objtax->term_id;	
  $taxonomy = $objtax->taxonomy;	
  $taxurl=get_term_link($termid,$taxonomy);
?>
<!-- LOOP -->	
	<?php if ( have_posts() ) : ?>
	<?php woocommerce_product_loop_start(); ?>	
	
<!-- WENN INHALT KATEGORIE-SEITE -->
	<?php if ( is_product_category('') ) { ?> 
			
			<!-- SEITEN-TITEL -->
			<div id="ist_kategorie">
			<div class="category-header">
				<div class="kategorien-header zuruck"><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Zurück</a></div>
				<div class="filter-header"><h3>Produkte filtern</h3></div>
			</div>

			<!-- CONTENT -->
			<section id="sitecontent">

			<!-- ALLE PRODUKTE ANZEIGEN -->
			<div class="kategorie-listing-container">
				<div class="kategorie-listing-header">
				 <div class="kategorie-listing-title"><h3><?php woocommerce_page_title(); ?></h3></div>
				</div>
				<div class="kategorie-listing-products">
					<div class="woocommerce columns-4">
					  <ul class="products">
				    <?php $args = array(
							'post_type' => 'product',
							'post_status' => 'publish',
							'order'		=> 'DESC',
							/*'posts_per_page' => 5,*/
							'orderby'	=> 'rand',
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy,
									'field'    => 'term_id',
									'terms'    => $termid
								),
							),
						);
						$querytax = new WP_Query( $args ); 
						
						?>
					<?php while ( $querytax->have_posts() ) : $querytax->the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
					   </ul>
					</div>
				</div>		
			</div>
			</section>
			</div>
	
	<?php } ?>
		
<!-- / LOOP -->
<?php woocommerce_product_loop_end(); ?>


	<?php
	/**
	* woocommerce_after_shop_loop hook.
	*
	* @hooked woocommerce_pagination - 10
	*/
	/* do_action( 'woocommerce_after_shop_loop' );*/
	?> 

	<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
	<?php wc_get_template( 'loop/no-products-found.php' ); ?>
	<?php endif; ?>


</section>    

<!-- SIDEBAR RIGHT
	<section id="sidebar" class="right">
		<?php //get_sidebar( 'right' ); ?>
	</section> -->

<?php get_footer(); ?>