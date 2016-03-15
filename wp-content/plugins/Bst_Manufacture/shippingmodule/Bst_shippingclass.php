<?php

include_once(ABSPATH.'wp-content/plugins/Bst_Manufacture/shippingmodule/class_show_shipping_wise_form.php');
include_once(ABSPATH.'wp-content/plugins/Bst_Manufacture/shippingmodule/class_show_weight_wise_shipping.php');
include_once(ABSPATH.'wp-content/plugins/Bst_Manufacture/shippingmodule/class_weight_htmlform.php');

global $wpdb;

/* code to call shipping methods */

$obj = new WC_Shipping();
$shippingmethod=$obj->load_shipping_methods();


$obnew = new WC_Weight_Based_Shipping();

/*print_r(WC_Weight_Based_Shipping::PLUGIN_PREFIX);
die;*/


/* End */


/*
 * HTML Fields for flat rate
 */

$objshipfltrate = new WC_Shipping_Flat_Rateextended();
$fieldflatrate = $objshipfltrate->settingfield();

$flatrate='<table class="form-table"><tbody>';
$flatratefield =array();

unset($fieldflatrate['availability']);
unset($fieldflatrate['countries']);

$vid = get_the_ID();
$table =$wpdb->prefix.'yith_vendors_shipping';
$getresult = $wpdb->get_results('select * from '.$table.' where vid='.$vid);
$GLOBALS['shippingrest'] = $getresult;
if($getresult[0]->flatrate){
  $flatrateval =$getresult[0]->flatrate;
  $unserializeVal = unserialize($flatrateval);
  $fieldflatrate['enabled']['default']=$unserializeVal['enabled'];
  $fieldflatrate['cost']['default']=$unserializeVal['cost'];
}


foreach ($fieldflatrate as $title => $fieldArray) {

   $flatrate.='<tr valign="top">
      <th class="titledesc" scope="row">
        <label for="woocommerce_flat_rate_enabled">'.$fieldArray["title"].'</label>
              </th>';

   $inputarg = array('type'=> $fieldArray['type'],
                      'fieldarray'=> $fieldArray);

   $inputfield = inputtype($title, $inputarg, 'flatrate');

    $flatrate.='<td class="forminp">
        <fieldset>
          <legend class="screen-reader-text"><span>Enable/Disable</span></legend>
          <label for="woocommerce_flat_rate_enabled">'.$inputfield.' '.$fieldArray["label"].'</label><br></fieldset></td></tr>';
    }

$flatrate.='</tbody></table>';

/*
 * Html field of free shipping
 */

$fieldfreeship = $objshipfltrate->freeshippingForm();

$freeship='<table class="form-table"><tbody>';
$freeshipfield =array();


if($getresult[0]->freeship){
  $freeShipArr =$getresult[0]->freeship;
  $unserializeVal = unserialize($freeShipArr);
  $fieldfreeship['enabled']['default']=$unserializeVal['enabled'];
  $fieldfreeship['requires']['default']=$unserializeVal['requires'];
  $fieldfreeship['min_amount']['default']=$unserializeVal['min_amount'];
  $fieldfreeship['shipping_cost']['default']=$unserializeVal['shipping_cost'];
}


foreach ($fieldfreeship as $title => $fieldArray) {

   $freeship.='<tr valign="top">
      <th class="titledesc" scope="row">
        <label for="woocommerce_flat_rate_enabled">'.$fieldArray["title"].'</label>
              </th>';

   $inputarg = array('type'=> $fieldArray['type'],
                      'fieldarray' => $fieldArray);

   $inputfield = inputtype($title, $inputarg, 'freeshiping');

    $freeship.='<td class="forminp">
        <fieldset>
          <legend class="screen-reader-text"><span>Enable/Disable</span></legend>
          <label for="woocommerce_flat_rate_enabled">'.$inputfield.' '.$fieldArray["label"].'</label><br></fieldset></td></tr>';
    }

$freeship.='</tbody></table>';


/*
 * HTML field for fast delivery
 */

$objshipfastdelivery = new WC_Shipping_Flat_Rateextended();
$fieldfastdelivery = $objshipfastdelivery->settingfield();

$fastdelivery='<table class="form-table"><tbody>';
$fastdeliveryfield =array();

unset($fieldfastdelivery['availability']);
unset($fieldfastdelivery['countries']);

if($getresult[0]->fastdelivery){
  $fastShipArr =$getresult[0]->fastdelivery;
  $unserializeVal = unserialize($fastShipArr);
  $fieldfastdelivery['enabled']['default']=$unserializeVal['enabled'];
  $fieldfastdelivery['cost']['default']=$unserializeVal['cost'];
}

foreach ($fieldfastdelivery as $title => $fieldArray) {

   $fastdelivery.='<tr valign="top">
      <th class="titledesc" scope="row">
        <label for="woocommerce_flat_rate_enabled">'.$fieldArray["title"].'</label>
              </th>';

   $inputarg = array('type'=> $fieldArray['type'],
                      'fieldarray' => $fieldArray);

   $inputfield = inputtype($title, $inputarg, 'fastdelivery');

    $fastdelivery.='<td class="forminp">
        <fieldset>
          <legend class="screen-reader-text"><span>Enable/Disable</span></legend>
          <label for="woocommerce_flat_rate_enabled">'.$inputfield.' '.$fieldArray["label"].'</label><br></fieldset></td></tr>';
    }

$fastdelivery.='</tbody></table>';


/*
 * HTML field for wight wise shipping
 */

$objweightwiseshipp = new BST_Weight_Based_Shipping();

/* Array of form field
 */


$formhtmlarr = $objweightwiseshipp->htmlform(); 

//__p($formhtmlarr);

 
/* convert array to html
 */

$objhtmlel = new wightshipphtmlforms();
  //$objvaaa="<table class='form-table'><tbody>";
unset($formhtmlarr['availability']);
unset($formhtmlarr['countries']);
unset($formhtmlarr['shipping_class_rates']);

if($getresult[0]->weightbased){
  
  $weightShipArr =$getresult[0]->weightbased;
  $unserializeVal = unserialize($weightShipArr);
  $formhtmlarr['enabled']['default']=$unserializeVal['enabled'];
  $formhtmlarr['weight']['totalcondition']=$unserializeVal['weight']['totalcondition'];
  $formhtmlarr['subtotal']['totalcondition']=$unserializeVal['subtotal']['totalcondition'];
  $formhtmlarr['maxiumm_weight']['default']=$unserializeVal['maxiumm_weight'];
  $formhtmlarr['maximum_cost']['default']=$unserializeVal['maximum_cost'];
  $formhtmlarr['weight']['container']=$unserializeVal['weight'];
  $formhtmlarr['subtotal']['container']=$unserializeVal['subtotal'];
}

 foreach ($formhtmlarr as $key => $data) {
    $objvaaa .= $objhtmlel->generateRangeHtml($key,$data,'wigthshipping');
 }

 $objvaaa.="</div>";


/*
 * code to add accordian
 */

$accordian="<div class='ccccontainer'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='accordion-wrapper'>";

$i=1;
foreach ($shippingmethod as $shipkey => $shipvalue) {
  //__p($shipvalue);
   if($shipvalue->enabled == 'yes'){


      $title = $shipvalue->settings['title'];
      $tb=($i==1)?$tb="active":"";
      $accordian.="<div class='ac-pane ".$tb."'>
                                <a href='#' class='ac-title' >
                                    <span>".$title."</span>
                                    <i class='fa'></i>
                                </a>
                                <div class='ac-content'>";

      if($shipvalue->id == 'flat_rate'){
          $accordian.=$flatrate;

      }elseif($shipvalue->id == 'free_shipping'){
          $accordian.=$freeship;        
      }elseif($shipvalue->id == 'international_delivery'){
          $accordian.=$fastdelivery; 
      }elseif($shipvalue->id == 'main'){
          $accordian.=$objvaaa; 
      }
                                    
      $accordian.="</div></div>";
      $i++;
   }
}


 $accordian.="</div></div></div></div>";
$script_toaddhiddenvalue ="<script>
  jQuery(document).ready(function(){
    jQuery('input[type=\"checkbox\"]').click(function(){
      hiddenval = jQuery(this).attr('datahidden');
      if(jQuery(this).is(\":checked\") == true){
        jQuery('.'+hiddenval).val(1);
      }else{
        jQuery('.'+hiddenval).val(0);
      }
    });

    /* for weightbased shipping */
    jQuery('form').submit(function(){
      var totallgth = jQuery('.weightcls .wightfield').length;
      jQuery('.totalweightcon').val(totallgth);

      var totalsublgth = jQuery('.ordersubtotal .wightfield').length;
      jQuery('.orderttlcount').val(totalsublgth);
    });

  })
</script>";

echo $accordian.= $script_toaddhiddenvalue;



/*
 * End accordian 
 */

?>