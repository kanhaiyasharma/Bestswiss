<?php if ( ! defined( 'ABSPATH' ) ) {exit;} ?>
<style>.shopcurrent a {color: #cea951!important;}</style>

<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div id="shop">

<!-- LOOP -->	
	<?php if ( have_posts() ) : ?>
	<?php woocommerce_product_loop_start(); ?>	
	
		
<!-- WENN INHALT KEINE KATEGORIE-SEITE -->
		<!-- SEITEN-TITEL -->
			<div class="category-header">
				<div class="kategorien-header"><h3>Kategorien</h3></div>
				<div class="filter-header"><h3>Produkte filtern</h3></div>
			</div>

			<!-- CONTENT -->
			<section id="sitecontent">
			
			<?php
			$taxonomy     = 'product_cat';
  			$orderby      = 'name';  
  			$empty        = 0;

  			$args = array(
        	 'taxonomy'     => $taxonomy,
        	 'orderby'      => $orderby,
        	 'hide_empty'   => $empty
  			);
  
			$all_categories = get_categories( $args );
 			foreach ($all_categories as $cat) { 
 				$termid=$cat->term_id;
 				$catlink=get_term_link($termid);
 				$catname=$cat->name;
 				?>
 
    		<!-- KATEGORIEN AUSGEBEN --> 
			<div class="kategorie-listing-container">
			
				<!-- HEADER --> 
				<div class="kategorie-listing-header">
					<div class="kategorie-listing-title"><h3><?php echo $cat->name ?></h3></div>
					
					<!-- ALLE-ANZEIGEN-LINK / NUR WENN MEHR ALS 5 PRODUKTE IN DER KATEGORIE SIND / ADJUST MIT $nbrproducts --> 
					<?php $nbrproducts = 5; 
					if ( ($cat->count) > $nbrproducts ) { ?>
					<div class="kategorie-listing-showall"><?php echo '<a href="' . get_term_link($cat->slug, 'product_cat') . '"><p>Alle anzeigen</p></a>';?></div>
   					<?php } ?> 
					</div>
				
				<!-- AUSGABE DER PRODUKTE --> 	
				<div class="kategorie-listing-products">
				   <div class="woocommerce columns-4">
				     <ul class="products">
					<?php 
						$args = array(
							'post_type' => 'product',
							'order'		=> 'DESC',
							'posts_per_page' => 5,
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

						  while ( $querytax->have_posts() ) : $querytax->the_post(); 
							 $ulhtml1= wc_get_template_part( 'content', 'product' );
						  endwhile; 

					?>
						<!-- ALLE-ANZEIGEN - ITEM / NUR WENN MEHR ALS 5 PRODUKTE IN DER KATEGORIE SIND --> 
						<?php 
						if ( ($cat->count) > $nbrproducts ) { ?>
		   				<div class="kategorie-item-showall"><?php echo '<a href="' . get_term_link($cat->slug, 'product_cat') . '">Alle anzeigen</a>'; ?></div>
		   				<?php } else { ?> 
		   				<div class="kategorie-listing-showall-end"><p>Keine weiteren <br>Produkte in dieser<br> Kategorie vorhanden.</p></div>
		   				<?php } ?>
						</ul>
					</div>
				</div>
				
				
   			
			</div>
			<?php } ?>
		
<!-- / LOOP -->
<?php woocommerce_product_loop_end(); ?>








	<!-- <?php echo do_shortcode('[products orderby="category" oder="desc"]')?>

	<?php woocommerce_product_subcategories(); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php wc_get_template_part( 'content', 'product' ); ?>
	<?php endwhile; // end of the loop. ?> -->
			
				
	

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
		<?php get_sidebar( 'right' ); ?>
	</section> -->

<?php get_footer(); ?>