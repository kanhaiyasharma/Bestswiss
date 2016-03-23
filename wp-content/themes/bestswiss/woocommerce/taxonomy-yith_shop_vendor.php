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
}
?>

<?php get_header(); 


$obj =get_queried_object();
$slug = $obj->slug;
$termid =$obj->term_id;


?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="pagewrap marken-detail">

<!-- LEFT COL -->
	<div class="marken-detail-col-left">
		<div class="category-header"><h3><?php echo single_term_title(); ?></h3></div>

	<!-- CONTENT -->
		<section id="sitecontent">
		<!-- LOOP -->
		<?php
		 $getHeaderLogo=get_woocommerce_term_meta($termid,'header_logo',true);

		 $getHeaderImage=get_woocommerce_term_meta($termid,'header_image',true);
		 if(is_numeric($getHeaderImage) && ($getHeaderImage!='')){
		 	$headimagarray = wp_get_attachment($getHeaderImage);
		 ?>
		 		<!-- Heade IMAGE -->
				<div class="marken-detail-image"><img alt="<?php echo $headimagarray['alt']; ?>" src="<?php echo $headimagarray['src']; ?>"/></div>
		 <?php
		 }elseif(is_numeric($getHeaderLogo) && ($getHeaderLogo!='')){
		 	$headimaglogoarray = wp_get_attachment($getHeaderLogo);
		 ?>
		 		<!-- Heade IMAGE -->
				<div class="marken-detail-image"><img alt="<?php echo $headimaglogoarray['alt']; ?>" src="<?php echo $headimaglogoarray['src']; ?>"/></div>
		 <?php
		 }

		 
		?>
		
	

	<!-- CONTENT -->
		<div class="marken-detail-content">

		<div>
		   <?php
			$Beschreibungeditor=get_woocommerce_term_meta($termid,'Beschreibungeditor',true);
			echo $Beschreibungeditor;

			/* Gallery Images */
			$upimage=get_woocommerce_term_meta($termid,'upimage',true);
			/*__p($upimage);
			die;*/
			?>
		</div>

		<!-- BEZUGSQUELLE -->	
		<h5>Bezugsquelle</h5>
		<p>Link to Vendors-Category in Shop</p>
		
		<!-- FAZIT -->	
		<h5>Fazit Bestswiss</h5>
		<p class="fazit">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et.</p>	

		<!-- KONTAKT -->	
		<h5>Kontakt</h5>
		<p><?php echo get_woocommerce_term_meta($termid,'location',true); ?></p>
		<!-- <a href=#>www.company.ch</a> -->
	
		</div>
	<!-- / CONTENT -->
    	
		</section>
	</div> 

	<?php


	?>
  <?php 
   $divimage='';
		$argsprd = array(
			'post_type' => 'product',
			'tax_query' => array(
			    array(
			    'taxonomy' => 'yith_shop_vendor',
			    'field' => 'id',
			    'terms' => $termid
			     )
			  )
			);
		$prodArray = new WP_Query($argsprd);

  if(count($prodArray->posts)){ ?>
<!-- RIGHT COL -->
	<div class="marken-detail-col-right">
		<div class="category-header"><h3>Produkte</h3></div>
	
		<?php 

			foreach ($prodArray->posts as $key => $value) {
				$id=$value->ID;
				$title =$value->post_title;
				$feat_image = get_post_thumbnail_id($id);
				
				$permalink = get_permalink($id);
				if($feat_image){
					$featarry = wp_get_attachment($feat_image);
					$divimage.='<div class="marken-detail-produkt-image"><a href="'.$permalink.'" title="'.$title.'"><img alt="'.$featarry['alt'].'" src="'.$featarry['src'].'"/></a></div>';
				}else{
					$headimaglogoarray = wp_get_attachment($getHeaderLogo);
					$divimage.='<div class="marken-detail-produkt-image"><a href="'.$permalink.'" title="'.$title.'"><img alt="'.$headimaglogoarray['alt'].'" src="'.$headimaglogoarray['src'].'"/></a></div>';

				}

			}
			echo $divimage;
		?>
		<!-- IMAGE -->
		

	</div>
	<?php } ?>

</div>
<?php get_footer(); ?>


