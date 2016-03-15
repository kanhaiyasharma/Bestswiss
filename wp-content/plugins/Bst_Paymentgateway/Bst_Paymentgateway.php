<?php

/**
 * Plugin Name: WooCommerce Payment Gateway - Postfinance
 * Plugin URI: #
 * Description: #
 * Version: 1.0.0
 * Author: Kanhaiya
 * Author URI: #
 * License: #
 *
 * @package WordPress
 * @author Kanhaiya Sharma
 * @since 1.0.0
 */

add_action( 'plugins_loaded', 'woocommerce_inspire_commerce_init', 0 );

function woocommerce_inspire_commerce_init() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
    return;
  };

  DEFINE ('PLUGIN_DIR', plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) . '/' );

$url ="https://e-payment.postfinance.ch/ncol/";
$mode="prod";
$woocommerce_postfinance_settings = get_option('woocommerce_postfinance_settings');

if($woocommerce_postfinance_settings['testmode']){
  $mode="test";
}
$url.=$mode."/orderstandard_utf8.asp";


$pspid= $woocommerce_postfinance_settings['psid'];
$shain= htmlspecialchars_decode($woocommerce_postfinance_settings['shain']);
$shaout= $woocommerce_postfinance_settings['shaout'];

  DEFINE ('GATEWAY_URL', $url);
  DEFINE ('PSPID', $pspid);
  DEFINE ('SHAIN', $shain);
  DEFINE ('SHAOUT', $shaout);
  DEFINE ('QUERY_URL', 'https://secure.inspiregateway.net/api/query.php');
  DEFINE ('CHECKOUT_URL', site_url().'/postfinance-checkout/');
//echo wp_title('');
  
	/**
	 * Inspire Commerce Gateway Class
	 */
		class WC_Inspire extends WC_Payment_Gateway {

			function __construct() {

        // Register plugin information
	      $this->id			    = 'postfinance';
	      $this->has_fields = true;
	      $this->supports   = array(
               'products', 
               'subscriptions',
               'subscription_cancellation', 
               'subscription_suspension', 
               'subscription_reactivation',
               'subscription_amount_changes',
               'subscription_date_changes',
               'subscription_payment_method_change',
               'refunds'
               );

        // Create plugin fields and settings
				$this->init_form_fields();
				$this->init_settings();

				// Get setting values
				foreach ( $this->settings as $key => $val ) $this->$key = $val;

        // Load plugin checkout icon
	      $this->icon = PLUGIN_DIR . 'images/cards.png';

        // Add hooks
				add_action( 'admin_notices',array( $this, 'inspire_commerce_ssl_check' ) );
				add_action( 'woocommerce_before_my_account',array( $this, 'add_payment_method_options' ) );
				add_action( 'woocommerce_receipt_inspire',array( $this, 'receipt_page' ) );
				add_action( 'woocommerce_update_options_payment_gateways',array( $this, 'process_admin_options' ) );
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
				add_action( 'wp_enqueue_scripts',array( $this, 'add_inspire_scripts' ) );
				add_action( 'scheduled_subscription_payment_inspire',array( $this, 'process_scheduled_subscription_payment'), 0, 3 );

		  }

     /**
       * Process a refund if supported
       * @param  int $order_id
       * @param  float $amount
       * @param  string $reason
       * @return  bool|wp_error True or false based on success, or a WP_Error object
       */
      public function process_refund( $order_id, $amount = null, $reason = '' ) {
        $order = wc_get_order( $order_id );

        $transaction_id = null;

        $args = array(
            'post_id' => $order->id,
            'approve' => 'approve',
            'type' => ''
        );
 
        remove_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ) );
 
        $comments = get_comments( $args );
 
        foreach ( $comments as $comment ) {
          if (strpos($comment->comment_content, 'Transaction ID: ') !== false) {
            $exploded_comment = explode(": ", $comment->comment_content);
            $transaction_id = $exploded_comment[1];
          }
        }
 
        add_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ) );

        if ( ! $order || ! $transaction_id ) {
          return false;
        }

        // Add transaction-specific details to the request
        $transaction_details = array (
          'username'      => $this->username,
          'password'      => $this->password,
          'type'          => 'refund',
          'transactionid' => $transaction_id,
          'ipaddress'     => $_SERVER['REMOTE_ADDR'],
        );

        if ( ! is_null( $amount ) ) {
          $transaction_details['amount'] = number_format( $amount, 2, '.', '' );
        }


        // Send request and get response from server
        $response = $this->post_and_get_response( $transaction_details );

        // Check response
        if ( $response['response'] == 1 ) {
          // Success
          $order->add_order_note( __( 'Inspire Commerce refund completed. Refund Transaction ID: ' , 'woocommerce' ) . $response['transactionid'] );
          return true;
        } else {
          // Failure
          $order->add_order_note( __( 'Inspire Commerce refund error. Response data: ' , 'woocommerce' ) . http_build_query($response));
          return false;
        }
      }


      /**
       * Check if SSL is enabled and notify the user.
       */
      function inspire_commerce_ssl_check() {
        if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'no' && $this->enabled == 'yes' ) {
            echo '<div class="error"><p>' . sprintf( __('Inspire Commerce is enabled and the <a href="%s">force SSL option</a> is disabled; your checkout is not secure! Please enable SSL and ensure your server has a valid SSL certificate.', 'woothemes' ), admin_url( 'admin.php?page=woocommerce' ) ) . '</p></div>';
            }
      }

      /**
       * Initialize Gateway Settings Form Fields.
       */
	    function init_form_fields() {

	      $this->form_fields = array(
	      'enabled'     => array(
	        'title'       => __( 'Enable/Disable', 'woothemes' ),
	        'label'       => __( 'Enable PostFinance', 'woothemes' ),
	        'type'        => 'checkbox',
	        'description' => '',
	        'default'     => 'no'
	        ),
	      'testmode'     => array(
	        'title'       => __( 'Enable/Disable', 'woothemes' ),
	        'label'       => __( 'Enable Testmode', 'woothemes' ),
	        'type'        => 'checkbox',
	        'description' => '',
	        'default'     => 'no'
	        ),
	      'title'       => array(
	        'title'       => __( 'Title', 'woothemes' ),
	        'type'        => 'text',
	        'description' => __( 'This controls the title which the user sees during checkout.', 'woothemes' ),
	        'default'     => __( 'Credit Card (Inspire Commerce)', 'woothemes' )
	        ),
	      'description' => array(
	        'title'       => __( 'Description', 'woothemes' ),
	        'type'        => 'textarea',
	        'description' => __( 'This controls the description which the user sees during checkout.', 'woothemes' ),
	        'default'     => 'Pay with your credit card via Inspire Commerce.'
	        ),
	      'salemethod'  => array(
	        'title'       => __( 'Sale Method', 'woothemes' ),
	        'type'        => 'select',
	        'description' => __( 'Select which sale method to use. Authorize Only will authorize the customers card for the purchase amount only.  Authorize &amp; Capture will authorize the customer\'s card and collect funds.', 'woothemes' ),
	        'options'     => array(
	          'sale' => 'Authorize &amp; Capture',
	          'auth' => 'Authorize Only'
	          ),
	        'default'     => 'Authorize &amp; Capture'
	        ),
	      'cardtypes'   => array(
	        'title'       => __( 'Accepted Cards', 'woothemes' ),
	        'type'        => 'multiselect',
	        'description' => __( 'Select which card types to accept.', 'woothemes' ),
	        'default'     => '',
	        'options'     => array(
	          'MasterCard'			     => 'MasterCard',
	          'Visa'	  				 => 'Visa',
	          'PostFinance E-Finance' 	 => 'PostFinance E-Finance',
	          'PostFinance Card'  		 => 'PostFinance Card'
	          ),
	        ),
	      	'psid'    => array(
	        'title'       => __( 'PSID', 'woothemes' ),
	        'type'        => 'text',
	        'description' => __( '', 'woothemes' ),
	        'default'     => ''
	        ),
	      	'shain'       => array(
	        'title'       => __( 'SHA-IN', 'woothemes' ),
	        'type'        => 'text',
	        'description' => __( '', 'woothemes' ),
	        'default'     => __( '', 'woothemes' )
	        ),
	        'shaout'       => array(
	        'title'       => __( 'SHA-OUT', 'woothemes' ),
	        'type'        => 'text',
	        'description' => __( '', 'woothemes' ),
	        'default'     => __( '', 'woothemes' )
	        ),

	      'cvv'         => array(
	        'title'       => __( 'CVV', 'woothemes' ),
	        'type'        => 'checkbox',
	        'label'       => __( 'Require customer to enter credit card CVV code', 'woothemes' ),
	        'description' => __( '', 'woothemes' ),
	        'default'     => 'yes'
	        ),

			);
		  }


      /**
       * UI - Admin Panel Options
       */
			function admin_options() { ?>
				<h3><?php _e( 'postfinance','woothemes' ); ?></h3>
			    <p><?php _e( 'The Inspire Commerce Gateway is simple and powerful.  The plugin works by adding credit card fields on the checkout page, and then sending the details to Inspire Commerce for verification.  <a href="http://www.inspirecommerce.com/woocommerce/">Click here to get paid like the pros</a>.', 'woothemes' ); ?></p>
			    <table class="form-table">
					<?php $this->generate_settings_html(); ?>
				</table>
			<?php }
      /**
       * UI - Payment page fields for Inspire Commerce.
       */
			function payment_fields() {
          		// Description of payment method from settings
          		if ( $this->description ) { ?>
            		<p><?php echo $this->description; ?></p>
      		<?php } ?>

			<fieldset  style="padding-left: 40px;">
		        <?php
		          $user = wp_get_current_user();
		          if($user->user_login!=''  && $user->ID!=''){
		          	//$this->check_payment_method_conversion( $user->user_login, $user->ID );
		          }

                  ?>
		           
              		<fieldset>
              				<!-- Show input boxes for new data -->
              			<div id="inspire-new-info">
              					
								<!-- Credit card number -->
            			    <p class="form-row  tobehide">
							<label for="cardtype"><?php echo __( 'Card type', 'woocommerce' ) ?> <span class="required">*</span></label>
						   <ul class="wc_payment_methods payment_methods methods">
          						<?php  foreach( $this->cardtypes as $type ) { ?>
                    				<li><input checked="checked" type='radio' name="postfinancePM" value="<?php echo $type ?>" /><label for="payment_method_postfinance">
										<?php echo __( $type, 'woocommerce' ) ?> </label></li>
										
          						<?php } ?>
          					</ul>
          					</p>
          					</div>	
          			</fieldset>   
      			</fieldset>
			

			<script type="text/javascript">
				jQuery(document).ready(function(){

					jQuery(document).ajaxComplete(function(event, xhr, settings) {
					  
					  if(xhr.responseJSON.hidden_form_fields=='truee'){
					  	
					  	jQuery('.psoform').html(xhr.responseJSON.array_val);
					  	jQuery('.psoform').submit();
					  }
					});
				});
			</script>

<?php
    }

		/**
		 * Process the payment and return the result.
		 */
		function process_payment( $order_id ) {

			global $woocommerce;

			$order = new WC_Order( $order_id );

      		$paymentmethod = $this->get_post('payment_method');
	  		$cardtype = $this->get_post('postfinancePM');

	        // Full request, new customer or new information
	        $base_request = array (
	          'firstname'   => $order->billing_first_name,
	          'lastname' 	=> $order->billing_last_name,
	          'address1' 	=> $order->billing_address_1,
	          'city' 	    => $order->billing_city,
	          'state' 		=> $order->billing_state,
	          'zip' 		=> $order->billing_postcode,
	          'country' 	=> $order->billing_country,
	          'phone' 		=> $order->billing_phone,
	          'email'       => $order->billing_email,
	          );

	        $shipping_address= array(
					            'first_name' => $order->shipping_first_name,
					            'last_name'  => $order->shipping_last_name,
					            'company'    => $order->shipping_company,
					            'address_1'  => $order->shipping_address_1,
					            'address_2'  => $order->shipping_address_2,
					            'city'       => $order->shipping_city,
					            'state'      => $order->shipping_state,
					            'postcode'   => $order->shipping_postcode,
					            'country'    => $order->shipping_country
					        	);

		      // Add transaction-specific details to the request
		      $transaction_details = array (
		        'username'  => $this->username,
		        'password'  => $this->password,
		        'amount' 		=> $order->order_total,
		        'type' 			=> $this->salemethod,
		        'payment' 	=> $paymentmethod,
		        'orderid' 	=> $order->id,
		        'ipaddress' => $_SERVER['REMOTE_ADDR'],
		        );

      		 // Send request and get response from server
      		 $mergearr =array_merge( $base_request, $transaction_details );
      		 $accepturl = $woocommerce->cart->get_cart_url().'?cancel_order=true&order_id='.$order_id;
      		 $total = $woocommerce->cart->total*100;
      		 $cn=$order->billing_first_name.' '.$order->billing_last_name;
      		 $com = $orderid->post->post_title;
      		 $currency = get_woocommerce_currency();
      		 $language = get_locale();
      		 $operation = 'SAL';
      		 $orderID=$order_id;
      		 $OWNERADDRESS = $base_request['address1'];
      		 $OWNERCTY = $base_request['city'];
      		 $OWNERTOWN = $base_request['city'];
      		 $OWNERZIP = $base_request['zip'];
      		 $PARAMPLUS ='feedbackreturninparameter';


      		 $postf=array();
      		 $postf['ACCEPTURL']=$accepturl;
      		 $postf['AMOUNT']=$total;
      		 $postf['BACKURL']=$accepturl;
      		 $postf['CANCELURL']=$accepturl;
      		 $postf['CN']=$cn;
      		 $postf['COM']=$com;
      		 $postf['CURRENCY']=$currency;
      		 $postf['DECLINEURL']=$accepturl;
      		 $postf['ECOM_BILLTO_POSTAL_CITY']=$base_request['city'];
      		 $postf['ECOM_BILLTO_POSTAL_COUNTRYCODE']=$base_request['country'];
      		 $postf['ECOM_BILLTO_POSTAL_NAME_FIRST']=$base_request['firstname'];
      		 $postf['ECOM_BILLTO_POSTAL_NAME_LAST']=$base_request['lastname'];
      		 $postf['ECOM_BILLTO_POSTAL_POSTALCODE']=$base_request['zip'];
      		 $postf['ECOM_BILLTO_POSTAL_STREET_LINE1']=$base_request['address1'];
      		 $postf['ECOM_SHIPTO_ONLINE_EMAIL']=$base_request['email'];
      		 $postf['ECOM_SHIPTO_POSTAL_CITY']=$shipping_address['city'];
      		 $postf['ECOM_SHIPTO_POSTAL_COUNTRYCODE']=$shipping_address['country'];
      		 $postf['ECOM_SHIPTO_POSTAL_NAME_FIRST']=$shipping_address['first_name'];
      		 $postf['ECOM_SHIPTO_POSTAL_NAME_LAST']=$shipping_address['last_name'];
      		 $postf['ECOM_SHIPTO_POSTAL_POSTALCODE']=$shipping_address['postcode'];
      		 $postf['ECOM_SHIPTO_POSTAL_STREET_LINE1']=$shipping_address['address_1'];
      		 $postf['EMAIL']=$base_request['email'];
      		 $postf['EXCEPTIONURL']=$accepturl;
      		 $postf['LANGUAGE']=$language;
      		 $postf['OPERATION']=$operation;
      		 $postf['ORDERID']=$orderID;
      		 $postf['OWNERADDRESS']=$OWNERADDRESS;
      		 $postf['OWNERCTY']=$OWNERCTY;
      		 $postf['OWNERTOWN']=$OWNERCTY;
      		 $postf['OWNERZIP']=$OWNERZIP;
      		 $postf['PARAMPLUS']=$PARAMPLUS;
      		 $postf['TITLE']=get_option('blogname');
			 $postf['BGCOLOR']='#CEA951';
			 $postf['TXTCOLOR']='#000000';
			 $postf['TBLBGCOLOR']='#96588A';
			 $postf['TBLTXTCOLOR']='#000000';
			 $postf['BUTTONBGCOLOR']='#96588A';
			 $postf['BUTTONTXTCOLOR']='#000000';
			 //$postf['LOGO']='http://www.bestswiss.ch/de/themes/bestswiss_2013/img/box_logo_main_new_v2.png';
      		 $postf['PM']=$cardtype;
      		 if($cardtype=='MasterCard'){
      		 	$postf['PM']='CreditCard';
      		 	$postf['BRAND']='MasterCard';
      		 }
      		 if($cardtype=='Visa'){
      		 	$postf['PM']='CreditCard';
      		 	$postf['BRAND']='VISA';
      		 }
      		 $postf['PSPID']=PSPID;
             ksort($postf);

      		 $keystr='';
      		 $formcontainerval='';
      		 foreach ($postf as $key => $value) {
      		 	if($value){
      		 		$keystr.=$key."=".$value."".SHAIN;
      		 		$formcontainerval.="<input type='hidden' name='".$key."' value='".$value."' />";
      		 	}
      		 }#end foreach

      		 $shakey=sha1($keystr);
      		 $formcontainerval.="<input type='hidden' name='SHASIGN' value='".$shakey."' />";


      		 
      

        // Return thank you redirect
        return array (
          'result'   => 'success',
          'hidden_form_fields' =>'truee',
          'array_val' => $formcontainerval
        );

      

		}

		/**
		 * Process a payment for an ongoing subscription.
		 */
    function process_scheduled_subscription_payment( $amount_to_charge, $order, $product_id ) {

      $user = new WP_User( $order->user_id );
      $this->check_payment_method_conversion( $user->user_login, $user->ID );
      $customer_vault_ids = get_user_meta( $user->ID, 'customer_vault_ids', true );
      $payment_method_number = get_post_meta( $order->id, 'payment_method_number', true );

      $inspire_request = array (
				'username' 		      => $this->username,
				'password' 	      	=> $this->password,
				'amount' 		      	=> $amount_to_charge,
        		'type' 			        => $this->salemethod,
				'billing_method'    => 'recurring',
        );

      $id = $customer_vault_ids[ $payment_method_number ];
      if( substr( $id, 0, 1 ) !== '_' ) $inspire_request['customer_vault_id'] = $id;
      else {
        $inspire_request['customer_vault_id'] = $user->user_login;
        $inspire_request['billing_id']        = substr( $id , 1 );
        $inspire_request['ver']               = 2;
      }

      $response = $this->post_and_get_response( $inspire_request );

      if ( $response['response'] == 1 ) {
        // Success
        $order->add_order_note( __( 'Inspire Commerce scheduled subscription payment completed. Transaction ID: ' , 'woocommerce' ) . $response['transactionid'] );
        WC_Subscriptions_Manager::process_subscription_payments_on_order( $order );

			} else if ( $response['response'] == 2 ) {
        // Decline
        $order->add_order_note( __( 'Inspire Commerce scheduled subscription payment failed. Payment declined.', 'woocommerce') );
        WC_Subscriptions_Manager::process_subscription_payment_failure_on_order( $order );

      } else if ( $response['response'] == 3 ) {
        // Other transaction error
        $order->add_order_note( __( 'Inspire Commerce scheduled subscription payment failed. Error: ', 'woocommerce') . $response['responsetext'] );
        WC_Subscriptions_Manager::process_subscription_payment_failure_on_order( $order );

      } else {
        // No response or unexpected response
        $order->add_order_note( __('Inspire Commerce scheduled subscription payment failed. Couldn\'t connect to gateway server.', 'woocommerce') );

      }
    }

    /**
     * Get details of a payment method for the current user from the Customer Vault
     */
    function get_payment_method( $payment_method_number ) {

      if( $payment_method_number < 0 ) die( 'Invalid payment method: ' . $payment_method_number );

      $user = wp_get_current_user();
      $customer_vault_ids = get_user_meta( $user->ID, 'customer_vault_ids', true );
      if( $payment_method_number >= count( $customer_vault_ids ) ) return null;

      $query = array (
        'username' 		      => $this->username,
        'password' 	      	=> $this->password,
        'report_type'       => 'customer_vault',
        );

      $id = $customer_vault_ids[ $payment_method_number ];
      if( substr( $id, 0, 1 ) !== '_' ) $query['customer_vault_id'] = $id;
      else {
        $query['customer_vault_id'] = $user->user_login;
        $query['billing_id']        = substr( $id , 1 );
        $query['ver']               = 2;
      }
      $response = wp_remote_post( QUERY_URL, array(
        'body'  => $query,
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array(),
        'ssl_verify' => false
        )
      );

      //Do we have an error?
      if( is_wp_error( $response ) ) return null;

      // Check for empty response, which means method does not exist
      if ( trim( strip_tags( $response['body'] ) ) == '' ) return null;

      // Format result
      $content = simplexml_load_string( $response['body'] )->customer_vault->customer;
      if( substr( $id, 0, 1 ) === '_' ) $content = $content->billing;

      return $content;
    }

    /**
     * Check if a user's stored billing records have been converted to Single Billing. If not, do it now.
     */
    function check_payment_method_conversion( $user_login, $user_id ) {
      if( ! $this->user_has_stored_data( $user_id ) && $this->get_mb_payment_methods( $user_login ) != null ) $this->convert_mb_payment_methods( $user_login, $user_id );
    }

    /**
     * Convert any Multiple Billing records stored by the user into Single Billing records
     */
    function convert_mb_payment_methods( $user_login, $user_id ) {

      $mb_methods = $this->get_mb_payment_methods( $user_login );
      foreach ( $mb_methods->billing as $method ) $customer_vault_ids[] = '_' . ( (string) $method['id'] );
      // Store the payment method number/customer vault ID translation table in the user's metadata
      add_user_meta( $user_id, 'customer_vault_ids', $customer_vault_ids );

      // Update subscriptions to reference the new records
      if( class_exists( 'WC_Subscriptions_Manager' ) ) {

        $payment_method_numbers = array_flip( $customer_vault_ids );
        foreach( (array) ( WC_Subscriptions_Manager::get_users_subscriptions( $user_id ) ) as $subscription ) {
          update_post_meta( $subscription['order_id'], 'payment_method_number', $payment_method_numbers[ '_' . get_post_meta( $subscription['order_id'], 'billing_id', true ) ] );
          delete_post_meta( $subscription['order_id'], 'billing_id' );
        }

      }
    }

    /**
     * Get the user's Multiple Billing records from the Customer Vault
     */
    function get_mb_payment_methods( $user_login ) {

      if( $user_login == null ) return null;

      $query = array (
        'username' 		      => $this->username,
        'password' 	      	=> $this->password,
        'report_type'       => 'customer_vault',
        'customer_vault_id' => $user_login,
        'ver'               => '2',
        );
      $content = wp_remote_post( QUERY_URL, array(
        'body'  => $query,
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array(),
        'ssl_verify' => false
        )
      );

      if ( trim( strip_tags( $content['body'] ) ) == '' ) return null;
      return simplexml_load_string( $content['body'] )->customer_vault->customer;

    }

    /**
     * Check if the user has any billing records in the Customer Vault
     */
    function user_has_stored_data( $user_id ) {
      return get_user_meta( $user_id, 'customer_vault_ids', true ) != null;
    }

    /**
     * Update a stored billing record with new CC number and expiration
     */
    function update_payment_method( $payment_method, $ccnumber, $ccexp ) {

      global $woocommerce;
      $user =  wp_get_current_user();
      $customer_vault_ids = get_user_meta( $user->ID, 'customer_vault_ids', true );

      $id = $customer_vault_ids[ $payment_method ];
      if( substr( $id, 0, 1 ) == '_' ) {
        // Copy all fields from the Multiple Billing record
        $mb_method = $this->get_payment_method( $payment_method );
        $inspire_request = (array) $mb_method[0];
        // Make sure values are strings
        foreach( $inspire_request as $key => $val ) $inspire_request[ $key ] = "$val";
        // Add a new record with the updated details
        $inspire_request['customer_vault'] = 'add_customer';
        $new_customer_vault_id = $this->random_key();
        $inspire_request['customer_vault_id'] = $new_customer_vault_id;
      } else {
        // Update existing record
        $inspire_request['customer_vault'] = 'update_customer';
        $inspire_request['customer_vault_id'] = $id;
      }

      $inspire_request['username'] = $this->username;
      $inspire_request['password'] = $this->password;
      // Overwrite updated fields
      $inspire_request['cc_number'] = $ccnumber;
      $inspire_request['cc_exp'] = $ccexp;

      $response = $this->post_and_get_response( $inspire_request );

      if( $response ['response'] == 1 ) {
        if( substr( $id, 0, 1 ) === '_' ) {
          // Update references
          $customer_vault_ids[ $payment_method ] = $new_customer_vault_id;
          update_user_meta( $user->ID, 'customer_vault_ids', $customer_vault_ids );
        }
        wc_add_notice( __('Successfully updated your information!', 'woocommerce'), $notice_type = 'success' );
      } else wc_add_notice( __( 'Sorry, there was an error: ', 'woocommerce') . $response['responsetext'], $notice_type = 'error' );

    }

    /**
     * Delete a stored billing method
     */
    function delete_payment_method( $payment_method ) {

      global $woocommerce;
      $user = wp_get_current_user();
      $customer_vault_ids = get_user_meta( $user->ID, 'customer_vault_ids', true );

      $id = $customer_vault_ids[ $payment_method ];
      // If method is Single Billing, actually delete the record
      if( substr( $id, 0, 1 ) !== '_' ) {

        $inspire_request = array (
          'username' 		      => $this->username,
          'password' 	      	=> $this->password,
          'customer_vault'    => 'delete_customer',
          'customer_vault_id' => $id,
          );
        $response = $this->post_and_get_response( $inspire_request );
        if( $response['response'] != 1 ) {
          wc_add_notice( __( 'Sorry, there was an error: ', 'woocommerce') . $response['responsetext'], $notice_type = 'error' );
          return;
        }

      }

      $last_method = count( $customer_vault_ids ) - 1;

      // Update subscription references
      if( class_exists( 'WC_Subscriptions_Manager' ) ) {
        foreach( (array) ( WC_Subscriptions_Manager::get_users_subscriptions( $user->ID ) ) as $subscription ) {
          $subscription_payment_method = get_post_meta( $subscription['order_id'], 'payment_method_number', true );
          // Cancel subscriptions that were purchased with the deleted method
          if( $subscription_payment_method == $payment_method ) {
            delete_post_meta( $subscription['order_id'], 'payment_method_number' );
            WC_Subscriptions_Manager::cancel_subscription( $user->ID, WC_Subscriptions_Manager::get_subscription_key( $subscription['order_id'] ) );
          }
          else if( $subscription_payment_method == $last_method && $subscription['status'] != 'cancelled') {
            update_post_meta( $subscription['order_id'], 'payment_method_number', $payment_method );
          }
        }
      }

      // Delete the reference by replacing it with the last method in the array
      if( $payment_method < $last_method ) $customer_vault_ids[ $payment_method ] = $customer_vault_ids[ $last_method ];
      unset( $customer_vault_ids[ $last_method ] );
      update_user_meta( $user->ID, 'customer_vault_ids', $customer_vault_ids );

      wc_add_notice( __('Successfully deleted your information!', 'woocommerce'), $notice_type = 'success' );

    }

    /**
     * Check payment details for valid format
     */
		function validate_fields() {

      if ( $this->get_post( 'inspire-use-stored-payment-info' ) == 'yes' ) return true;

			global $woocommerce;

			// Check for saving payment info without having or creating an account
			if ( $this->get_post( 'saveinfo' )  && ! is_user_logged_in() && ! $this->get_post( 'createaccount' ) ) {
        wc_add_notice( __( 'Sorry, you need to create an account in order for us to save your payment information.', 'woocommerce'), $notice_type = 'error' );
        return false;
      }

			$cardType            = $this->get_post( 'cardtype' );
			$cardNumber          = $this->get_post( 'ccnum' );
			$cardCSC             = $this->get_post( 'cvv' );
			$cardExpirationMonth = $this->get_post( 'expmonth' );
			$cardExpirationYear  = $this->get_post( 'expyear' );

			$paymentmethod = $this->get_post('payment_method');
			$cardtype = $this->get_post('cardtype');

			
			if($paymentmethod == 'postfinance' && $cardtype == 'MasterCard'){
			// Check card number
			if ( empty( $cardNumber ) || ! ctype_digit( $cardNumber ) ) {
				wc_add_notice( __( 'Card number is invalid.', 'woocommerce' ), $notice_type = 'error' );
				return false;
			}
		   }


		   if($paymentmethod == 'postfinance' && $cardtype == 'MasterCard'){
			if ( $this->cvv == 'yes' ){
				// Check security code
				if ( ! ctype_digit( $cardCSC ) ) {
					wc_add_notice( __( 'Card security code is invalid (only digits are allowed).', 'woocommerce' ), $notice_type = 'error' );
					return false;
				}
				if ( ( strlen( $cardCSC ) != 3 && in_array( $cardType, array( 'Visa', 'MasterCard', 'Discover' ) ) ) || ( strlen( $cardCSC ) != 4 && $cardType == 'American Express' ) ) {
					wc_add_notice( __( 'Card security code is invalid (wrong length).', 'woocommerce' ), $notice_type = 'error' );
					return false;
				}
			}
		   }

		   if($paymentmethod == 'postfinance' && $cardtype == 'MasterCard'){
			// Check expiration data
			$currentYear = date( 'Y' );

			if ( ! ctype_digit( $cardExpirationMonth ) || ! ctype_digit( $cardExpirationYear ) ||
				 $cardExpirationMonth > 12 ||
				 $cardExpirationMonth < 1 ||
				 $cardExpirationYear < $currentYear ||
				 $cardExpirationYear > $currentYear + 20
			) {
				wc_add_notice( __( 'Card expiration date is invalid', 'woocommerce' ), $notice_type = 'error' );
				return false;
			}

			// Strip spaces and dashes
			$cardNumber = str_replace( array( ' ', '-' ), '', $cardNumber );

			return true;
		  }

		}

	/**
     * Send the payment data to the gateway server and return the response.
     */
    private function post_and_get_response( $request ) {
      global $woocommerce;

      // Encode request
      $post = http_build_query( $request, '', '&' );

			// Send request
      $content = wp_remote_post( GATEWAY_URL, array(
          'body'  => $post,
          'timeout' => 45,
          'redirection' => 5,
          'httpversion' => '1.0',
          'blocking' => true,
          'headers' => array(),
          'cookies' => array(),
          'ssl_verify' => false
         )
      );

      // Quit if it didn't work
      if ( is_wp_error( $content ) ) {
        wc_add_notice( __( 'Problem connecting to server at ', 'woocommerce' ) . GATEWAY_URL . ' ( ' . $content->get_error_message() . ' )', $notice_type = 'error' );
        return null;
      }

      // Convert response string to array
      $vars = explode( '&', $content['body'] );
      foreach ( $vars as $key => $val ) {
        $var = explode( '=', $val );
        $data[ $var[0] ] = $var[1];
      }

      // Return response array
      return $data;

    }

    /**
     * Add ability to view and edit payment details on the My Account page.(The WooCommerce 'force ssl' option also secures the My Account page, so we don't need to do that.)
     */
    function add_payment_method_options() {

      $user = wp_get_current_user();
      $this->check_payment_method_conversion( $user->user_login, $user->ID );
      if ( ! $this->user_has_stored_data( $user->ID ) ) return;

      if( $this->get_post( 'delete' ) != null ) {

        $method_to_delete = $this->get_post( 'delete' );
        $response = $this->delete_payment_method( $method_to_delete );

      } else if( $this->get_post( 'update' ) != null ) {

        $method_to_update = $this->get_post( 'update' );
        $ccnumber = $this->get_post( 'edit-cc-number-' . $method_to_update );

        if ( empty( $ccnumber ) || ! ctype_digit( $ccnumber ) ) {

          global $woocommerce;
          wc_add_notice( __( 'Card number is invalid.', 'woocommerce' ), $notice_type = 'error' );

        } else {

          $ccexp = $this->get_post( 'edit-cc-exp-' . $method_to_update );
          $expmonth = substr( $ccexp, 0, 2 );
          $expyear = substr( $ccexp, -2 );
          $currentYear = substr( date( 'Y' ), -2);

          if( empty( $ccexp ) || ! ctype_digit( str_replace( '/', '', $ccexp ) ) ||
            $expmonth > 12 || $expmonth < 1 ||
            $expyear < $currentYear || $expyear > $currentYear + 20 )
            {

            global $woocommerce;
            wc_add_notice( __( 'Card expiration date is invalid', 'woocommerce' ), $notice_type = 'error' );

          } else {

            $response = $this->update_payment_method( $method_to_update, $ccnumber, $ccexp );

          }
        }
      }

      ?>

      <h2>Saved Payment Methods</h2>
      <p>This information is stored to save time at the checkout and to pay for subscriptions.</p>

      <?php $i = 0;
      $current_method = $this->get_payment_method( $i );
      while( $current_method != null ) {

        if( $method_to_delete === $i && $response['response'] == 1 ) { $method_to_delete = null; continue; } // Skip over a deleted entry ?>

        <header class="title">

          <h3>
            Payment Method  <?php echo $i + 1; ?>
          </h3>
          <p>

            <button style="float:right" class="button" id="unlock-delete-button-<?php echo $i; ?>"><?php _e( 'Delete', 'woocommerce' ); ?></button>

            <button style="float:right; display:none" class="button" id="cancel-delete-button-<?php echo $i; ?>"><?php _e( 'No', 'woocommerce' ); ?></button>
            <form action="<?php echo get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ?>" method="post" style="float:right" >
              <input type="submit" value="<?php _e( 'Yes', 'woocommerce' ); ?>" class="button alt" id="delete-button-<?php echo $i; ?>" style="display:none">
              <input type="hidden" name="delete" value="<?php echo $i ?>">
            </form>
            <span id="delete-confirm-msg-<?php echo $i; ?>" style="float:left_; display:none">Are you sure? (Subscriptions purchased with this card will be canceled.)&nbsp;</span>

            <button style="float:right" class="button" id="edit-button-<?php echo $i; ?>" ><?php _e( 'Edit', 'woocommerce' ); ?></button>
            <button style="float:right; display:none" class="button" id="cancel-button-<?php echo $i; ?>" ><?php _e( 'Cancel', 'woocommerce' ); ?></button>

            <form action="<?php echo get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ?>" method="post" >

              <input type="submit" value="<?php _e( 'Save', 'woocommerce' ); ?>" class="button alt" id="save-button-<?php echo $i; ?>" style="float:right; display:none" >

              <span style="float:left">Credit card:&nbsp;</span>
              <input type="text" style="display:none" id="edit-cc-number-<?php echo $i; ?>" name="edit-cc-number-<?php echo $i; ?>" maxlength="16" />
              <span id="cc-number-<?php echo $i; ?>">
                <?php echo ( $method_to_update === $i && $response['response'] == 1 ) ? ( '<b>' . $ccnumber . '</b>' ) : $current_method->cc_number; ?>
              </span>
              <br />

              <span style="float:left">Expiration:&nbsp;</span>
              <input type="text" style="float:left; display:none" id="edit-cc-exp-<?php echo $i; ?>" name="edit-cc-exp-<?php echo $i; ?>" maxlength="5" value="MM/YY" />
              <span id="cc-exp-<?php echo $i; ?>">
                <?php echo ( $method_to_update === $i && $response['response'] == 1 ) ? ( '<b>' . $ccexp . '</b>' ) : substr( $current_method->cc_exp, 0, 2 ) . '/' . substr( $current_method->cc_exp, -2 ); ?>
              </span>

              <input type="hidden" name="update" value="<?php echo $i ?>">

            </form>

          </p>

        </header><?php

        $current_method = $this->get_payment_method( ++$i );

      }

    }

		function receipt_page( $order ) {
			echo '<p>' . __( 'Thank you for your order.', 'woocommerce' ) . '</p>';
		}

    /**
     * Include jQuery and our scripts
     */
    function add_inspire_scripts() {

      if ( ! $this->user_has_stored_data( wp_get_current_user()->ID ) ) return;

      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'edit_billing_details', PLUGIN_DIR . 'js/edit_billing_details.js', array( 'jquery' ), 1.0 );

      if ( $this->cvv == 'yes' ) wp_enqueue_script( 'check_cvv', PLUGIN_DIR . 'js/check_cvv.js', array( 'jquery' ), 1.0 );

    }

    /**
     * Get the current user's login name
     */
    private function get_user_login() {
      global $user_login;
      get_currentuserinfo();
      return $user_login;
		}

		/**
		 * Get post data if set
		 */
		private function get_post( $name ) {
			if ( isset( $_POST[ $name ] ) ) {
				return $_POST[ $name ];
			}
			return null;
		}

		/**
     * Check whether an order is a subscription
     */
		private function is_subscription( $order ) {
      return class_exists( 'WC_Subscriptions_Order' ) && WC_Subscriptions_Order::order_contains_subscription( $order );
		}

    /**
     * Generate a string of 36 alphanumeric characters to associate with each saved billing method.
     */
    function random_key() {

      $valid_chars = array( 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9' );
      $key = '';
      for( $i = 0; $i < 36; $i ++ ) {
        $key .= $valid_chars[ mt_rand( 0, 61 ) ];
      }
      return $key;

    }

	}

	/**
	 * Add the gateway to woocommerce
	 */
	function add_inspire_commerce_gateway( $methods ) {
		$methods[] = 'WC_Inspire';
		return $methods;
	}

	add_filter( 'woocommerce_payment_gateways', 'add_inspire_commerce_gateway' );


	function postfinanceForm() {
    	echo '<form method="post" action="'.GATEWAY_URL.'" class="psoform">
    	       
    	      </form>';
	}
	add_action( 'wp_footer', 'postfinanceForm', 100 );

}
