<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>

<!-- CONTENTS -->
<div id="product-detail">

	<!-- IMAGE -->
		<?php global $post, $woocommerce, $product;?>
		<div class="images">
			<?php if ( has_post_thumbnail() ) {
				$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
				$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
				$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('title'=> get_the_title( get_post_thumbnail_id() )) );

				$attachment_count = count( $product->get_gallery_attachment_ids() );

				if ( $attachment_count > 0 ) {
					$gallery = '[product-gallery]';
				} else {
					$gallery = '';
				}

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );

				} else {

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" style="margin-top:50px;" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

				} ?>

			<?php do_action( 'woocommerce_product_thumbnails' ); ?>
		</div>

	<!-- TITLE -->
		<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>

	<!-- PRICE -->
		<?php global $product; ?>
		<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<p class="price"><?php echo $product->get_price_html(); ?></p>
			<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
			<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
			<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
		</div>
	
	<!-- EXCERPT -->
		<?php global $post; ?>
		<?php if ( ! $post->post_excerpt ) { return; } ?>
		<div itemprop="description"><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?></div>

	<!-- CONTENT -->
		<?php global $post; ?>
		<?php $heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );?>
			<?php if ( $heading ): ?>
  			<h2><?php echo $heading; ?></h2>
			<?php endif; ?>
		<?php the_content(); ?>

	<!-- ADD - TO - CART / EXTERNAL PRODUCT-->
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<p class="cart"><a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></a></p>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<!-- ADD - TO - CART / GROUPED PRODUCT-->
		<?php global $product, $post; ?>
		<?php $parent_product_post = $post; ?>

		<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

		<form class="cart" method="post" enctype='multipart/form-data'>
			<table cellspacing="0" class="group_table">
				<tbody>
					<?php 	foreach ( $grouped_products as $product_id ) :
							if ( ! $product = wc_get_product( $product_id ) ) {continue;}
							if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && ! $product->is_in_stock() ) {continue;}

							$post    = $product->post;
							setup_postdata( $post );
					?>
				<tr>
					<td>
							<?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
								<?php woocommerce_template_loop_add_to_cart(); ?>
							<?php else : ?>
								<?php	$quantites_required = true;
										woocommerce_quantity_input( array(
											'input_name'  => 'quantity[' . $product_id . ']',
											'input_value' => ( isset( $_POST['quantity'][$product_id] ) ? wc_stock_amount( $_POST['quantity'][$product_id] ) : 0 ),
											'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
											'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ) ) );
								?>
							<?php endif; ?>
					</td>

					<td class="label">
						<label for="product-<?php echo $product_id; ?>">
							<?php echo $product->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink(), $product_id ) ) . '">' . esc_html( get_the_title() ) . '</a>' : esc_html( get_the_title() ); ?>
						</label>
					</td>

					<?php do_action ( 'woocommerce_grouped_product_list_before_price', $product ); ?>

					<td class="price">
						<?php
							echo $product->get_price_html();
							if ( $availability = $product->get_availability() ) {
									$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
									echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );}
						?>
					</td>
				</tr>
				
				<?php endforeach;

					// Reset to parent grouped product
					$post    = $parent_product_post;
					$product = wc_get_product( $parent_product_post->ID );
					setup_postdata( $parent_product_post );
				?>
				
				</tbody>
			</table>

			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

			<?php if ( $quantites_required ) : ?>
				<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
				<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

			<?php endif; ?>
		</form>

		<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

	<!-- ADD - TO - CART / SIMPLE PRODUCT-->
		<?php global $product; ?>
		<?php if( $product->is_type( 'simple' ) ){ ?>

		<?php if ( ! $product->is_purchasable() ) { return; }?>
		
		<?php
			// Availability
			$availability      = $product->get_availability();
			$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
			echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
		?>

		<?php if ( $product->is_in_stock() ) : ?>
			<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
			<form class="cart" method="post" enctype='multipart/form-data'>
	 			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 			<?php if ( ! $product->is_sold_individually() ) {
	 				woocommerce_quantity_input( array(
	 				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
	 				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ) );} 
	 			?>

	 			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
			
				<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
			</form>

		<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
		<?php endif; ?>
		<?php } ?>
		
	<!-- ADD - TO - CART / VARIABLE PRODUCT-->
		<?php global $product; ?>
		<?php if( $product->is_type( 'variable' ) ){ ?>

		<?php $attribute_keys = array_keys( $attributes ); ?>

		<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
		
		<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>">
			<?php do_action( 'woocommerce_before_variations_form' ); ?>

			<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			
				<!-- OUT-OF-STOCK-MESSAGE --> 
				<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
			
			<?php else : ?>
			
			<table class="variations" cellspacing="0">
				<tbody>
					<?php foreach ( $attributes as $attribute_name => $options ) : ?>
						<tr>
							<td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
							<td class="value">
								<?php
									$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
									wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
									echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : '';
								?>
							</td>
						</tr>
		        	<?php endforeach;?>
				</tbody>
			</table>

			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<div class="single_variation_wrap">
				<?php 
					do_action( 'woocommerce_before_single_variation' );

					/**
					* woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 	* @hooked woocommerce_single_variation - 10 Empty div for variation data.
					* @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 	*/
					do_action( 'woocommerce_single_variation' );

					/**
				 	* woocommerce_after_single_variation Hook.
				 	*/
					do_action( 'woocommerce_after_single_variation' );
				?>
			</div>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
			<?php endif; ?>
			<?php do_action( 'woocommerce_after_variations_form' ); ?>
		</form>
		<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

		<?php } ?>

	<!-- ADD - TO - CART / SINGLE VARIATION -->
		<?php global $product;?>
	
		<?php if( $product->is_type( 'variable' ) ){ ?>
	
			<script type="text/template" id="tmpl-variation-template">
    			<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>

    			<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>

    			<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
			</script>

			<script type="text/template" id="tmpl-unavailable-variation-template">
    			<p><?php _e( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ); ?></p>
			</script>

				<div class="woocommerce-variation-add-to-cart variations_button">
					<?php if ( ! $product->is_sold_individually() ) : ?>
						<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
					<?php endif; ?>
				
					<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
					<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
					<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
					<input type="hidden" name="variation_id" class="variation_id" value="0" />
				</div>
			
		<?php } ?>

	<!-- ATTRIBUTES -->
		<?php global $product;?>
		<p><?php echo $product->get_attribute( 'test attribute' ); ?></p>

	<!-- CUSTOM FIELDS -->
		<?php global $product;?>
		<?php echo get_post_meta( get_the_ID(), 'CF1', true ); ?>
	
	<!-- VENDOR -->
		<div style="display:block; width:300px; height:100px; background-color:#000000;">
		<p style="color:#ffffff;">INSERT VENDOR HERE</p>
		</div>

</div>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
<?php get_footer( 'shop' ); ?>
