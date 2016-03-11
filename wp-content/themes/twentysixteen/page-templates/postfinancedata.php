<?php
/*
* Template Name: Post Finance checkout page
*
*/

$woocommerce_postfinance_settings = get_option('woocommerce_postfinance_settings');

 global $woocommerce;

echo "<pre>";
 print_r($woocommerce);
 echo "</pre>";

 $order = new WC_Order($order_id);
 $user = new WP_User( $order->user_id );


echo "<pre>";
print_r($woocommerce_postfinance_settings);
print_r($_POST);
die;


?>