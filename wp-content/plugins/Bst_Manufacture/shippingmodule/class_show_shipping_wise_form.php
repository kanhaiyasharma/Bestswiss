<?php


class WC_Shipping_Flat_Rateextended extends WC_Shipping_Flat_Rate{

   public $form_fields=array();

   public function settingfield() {

     

			$cost_desc = __( 'Enter a cost (excl. tax) or sum, e.g. <code>10.00 * [qty]</code>.', 'woocommerce' ) . '<br/>' . __( 'Supports the following placeholders: <code>[qty]</code> = number of items, <code>[cost]</code> = cost of items, <code>[fee percent="10" min_fee="20"]</code> = Percentage based fee.', 'woocommerce' );

			/**
			 * Settings for flat rate shipping.
			 */
			$settings = array(
				'enabled' => array(
					'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
					'type' 			=> 'checkbox',
					'label' 		=> __( 'Enable this shipping method', 'woocommerce' ),
					'default' 		=> 'no',
				),
				'availability' => array(
					'title' 		=> __( 'Availability', 'woocommerce' ),
					'type' 			=> 'select',
					'default' 		=> 'all',
					'class'			=> 'availability wc-enhanced-select',
					'options'		=> array(
						'all' 		=> __( 'All allowed countries', 'woocommerce' ),
						'specific' 	=> __( 'Specific Countries', 'woocommerce' ),
					),
				),
				'countries' => array(
					'title' 		=> __( 'Specific Countries', 'woocommerce' ),
					'type' 			=> 'multiselect',
					'class'			=> 'wc-enhanced-select',
					'css'			=> 'width: 450px;',
					'default' 		=> '',
					'options'		=> WC()->countries->get_shipping_countries(),
					'custom_attributes' => array(
						'data-placeholder' => __( 'Select some countries', 'woocommerce' )
					)
				)/*,
				'tax_status' => array(
					'title' 		=> __( 'Tax Status', 'woocommerce' ),
					'type' 			=> 'select',
					'class'         => 'wc-enhanced-select',
					'default' 		=> 'taxable',
					'options'		=> array(
						'taxable' 	=> __( 'Taxable', 'woocommerce' ),
						'none' 		=> _x( 'None', 'Tax status', 'woocommerce' )
					)
				)*/,
				'cost' => array(
					'title' 		=> __( 'Cost', 'woocommerce' ),
					'type' 			=> 'price',
					'placeholder'	=> '',
					'description'	=> $cost_desc,
					'default'		=> 0,
					'desc_tip'		=> true
				)
			);


			return $settings;

	  
	}

	public function freeshippingForm(){

			
		$freeform = array(
			'enabled' => array(
				'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
				'type' 			=> 'checkbox',
				'label' 		=> __( 'Enable Free Shipping', 'woocommerce' ),
				'default' 		=> 'no'
			),
			'requires' => array(
				'title' 		=> __( 'Free Shipping Requires...', 'woocommerce' ),
				'type' 			=> 'select',
				'class'         => 'wc-enhanced-select',
				'default' 		=> '',
				'options'		=> array(
					'' 				=> __( 'N/A', 'woocommerce' ),
					/*'coupon'		=> __( 'A valid free shipping coupon', 'woocommerce' ),*/
					'amount' 	=> __( 'Based on order amount (defined below)', 'woocommerce' ),
					/*'either' 		=> __( 'A minimum order amount OR a coupon', 'woocommerce' ),*/
					/*'both' 			=> __( 'A minimum order amount AND a coupon', 'woocommerce' ),*/
				)
			),
			'min_amount' => array(
				'title' 		=> __( 'Minimum Order Amount', 'woocommerce' ),
				'type' 			=> 'price',
				'placeholder'	=> wc_format_localized_price( 0 ),
				'description' 	=> __( 'Users will need to spend this amount to get free shipping (if enabled above).', 'woocommerce' ),
				'default' 		=> '0',
				'desc_tip'		=> true
			),
			'shipping_cost' => array(
				'title' 		=> __( 'Shipping Cost', 'woocommerce' ),
				'type' 			=> 'price',
				'placeholder'	=> wc_format_localized_price( 0 ),
				'description' 	=> __( 'Users will need to spend this amount to get free shipping (if enabled below).', 'woocommerce' ),
				'default' 		=> '0',
				'desc_tip'		=> true
			)
		);

		return $freeform;
	

	}

}#class end


?>