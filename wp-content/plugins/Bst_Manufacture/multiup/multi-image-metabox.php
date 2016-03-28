<?php

/**
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 5. GLOBALS ↓
* @uses list_images (HOOK FILTER) : to rewrite images keys
* @uses images_cpt (HOOK FILTER) : to target cpt whith the image metabox
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
function list_my_images_slots( $cpt = false ){
	$list_images = apply_filters('list_images',array(
		'image1' => '_image1'
		), $cpt );
	return $list_images;
}
	
/** 
A) INITIALIZE
*/
add_action("admin_init", "add_image_metabox");
function add_image_metabox(){
	
}


 add_action('yith_shop_vendor_edit_form_fields', 'yith_shop_vendor_metabox_editgal', 10, 1);    
    function yith_shop_vendor_metabox_editgal($tgid){
    	     global $vendor,$social_fields,$owner,$owner_id,$vendor_admins;
			$GLOBALS['vendor']->id;
         ?>


         <!-- start -->
         		<tr class="form-field yith-choosen">
    <td colspan="2">
        <style type="text/css">
  .exec
    {
      overflow-x: scroll;
    }
    .form-table,.form-table td, .form-table th,#myTable{border:none;}
  
</style>


<!-- tabcontainer start -->


     	 <div id="top-level" class="top-div">
     <ul>
       <li><a href="#exec">Profile</a></li>
        <li><a href="#exec1">Gallery</a></li>
        <li><a href="#exec2">Snippets</a></li>
        <li><a href="#exec3">Shipping</a></li>
        <li><a href="#exec4">Payment Acceptance</a></li>
     </ul>

    <!-- tab 1 start -->
    <div id="exec" class="tab_content">
        	
             <table id="myTable" border="1"> 
               <tr>
                 <?php

						$trmid = $GLOBALS['vendor']->id;
 						YITH_Vendors()->admin->add_upload_field( 'table', $GLOBALS['vendor']->header_image ) ?>
               </tr>
               <tr class="form-field yith-choosen" style="display:none;">
				    <th scope="row" valign="top">
				        <label for="key_user"><?php _e( 'Vendor Shop Owner', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="hidden"
				               class="wc-customer-search"
				               id="key_user"
				               name="yith_vendor_data[owner]"
				               data-placeholder="<?php esc_attr_e( 'Search for a shop owner&hellip;', 'yith_wc_product_vendors' ); ?>"
				               data-selected="<?php echo esc_attr( $owner ); ?>"
				               value="<?php echo esc_attr( $owner_id ); ?>"
				               data-allow_clear="true" />
				        <br />
				        <span class="description"><?php _e( 'User that can manage products in this shop and view sale reports.', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>

				<tr class="form-field yith-choosen" style="display:none;">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_admins"><?php _e( 'Vendor Shop Admins', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="hidden"
				               class="wc-customer-search"
				               id="yith_vendor_admins"
				               name="yith_vendor_data[admins]"
				               data-placeholder="<?php esc_attr_e( 'Search for a shop admins&hellip;', 'yith_wc_product_vendors' ); ?>"
				               data-selected='<?php echo $vendor_admins['selected'] ?>'
				               value="<?php echo $vendor_admins['value'] ?>"
				               data-allow_clear="true"
				               data-multiple="true" />
				        <br />
				        <span class="description"><?php _e( 'User that can manage products in this vendor shop and view sale reports.', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>
				<tr class="form-field yith-choosen">
				    <th scope="row" valign="top">
				        <h4><?php _e( 'Contact information :', 'yith_wc_product_vendors' ) ?></h4>
				    </th>
				</tr>

				<tr class="form-field yith-choosen">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_location"><?php _e( 'Location', 'yith_wc_product_vendors' ); ?></label>
				    </th>

				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[location]" id="yith_vendor_location" placeholder="MyStore S.A. Avenue MyStore 55, 1800 Vevey, Switzerland" value="<?php echo $vendor->location ?>" /><br />
				    </td>
				</tr>

				<tr class="form-field yith-choosen">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_Firstname"><?php _e( 'Firstname', 'yith_wc_product_vendors' ); ?></label>
				    </th>

				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[bstFirstname]" id="yith_vendor_Firstname" placeholder="" value="<?php echo $vendor->bstFirstname ?>" /><br />
				    </td>
				</tr>

				<tr class="form-field yith-choosen">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_Lastname"><?php _e( 'Lastname', 'yith_wc_product_vendors' ); ?></label>
				    </th>

				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[bstLastname]" id="yith_vendor_Lastname" placeholder="" value="<?php echo $vendor->bstLastname ?>" /><br />
				    </td>
				</tr>

				<tr class="form-field yith-choosen">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_Anrede"><?php _e( 'Anrede', 'yith_wc_product_vendors' ); ?></label>
				    </th>

				    <td>
				        <select name="yith_vendor_data[bstAnrede]">
				        	<option <?php if($vendor->bstAnrede =='Dear' ){ echo "selected";} ?> value="Dear">Dear</option>
				        	<option <?php if($vendor->bstAnrede =='Mister' ){ echo "selected";} ?> value="Mister">Mister</option>
				        	<option <?php if($vendor->bstAnrede =='Miss' ){ echo "selected";} ?> value='Miss'>Miss</option>
				        </select><br />
				    </td>
				</tr>


				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_store_email"><?php _e( 'Store email', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[store_email]" id="yith_vendor_store_email" value="<?php echo $vendor->store_email ?>" /><br />
				    </td>
				</tr>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_telephone"><?php _e( 'Telephone', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[telephone]" id="yith_vendor_telephone" value="<?php echo $vendor->telephone ?>" /><br />
				    </td>
				</tr>
             	<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_vat"><?php _e( 'VAT/SSN', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[vat]" id="yith_vendor_vat" value="<?php echo $vendor->vat ?>" /><br />
				        <span class="description"><?php _e( 'Vendor\'s VAT/SSN.', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>
				<tr class="form-field term-slug-wrap">
				    <th scope="row"><label for="Untertitel">Legal Name</label></th>
				    <?php $legal_name= get_woocommerce_term_meta($trmid,'legal_name',true); ?>
				    <td> <input type="text" class="regular-text" name="yith_vendor_data[legal_name]" id="yith_vendor_legal_name" value="<?php echo $legal_name; ?>" /></td>
				</tr>  
				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_legal_notes"><?php _e( 'Company legal notes', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[legal_notes]" id="yith_vendor_legal_notes" value="<?php echo $vendor->legal_notes ?>" /><br />
				        <span class="description"><?php _e( 'Insert company legal notes (e.g. Managing Directors, Court of registration, Commercial registration number, ecc.)', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>
				<tr class="form-field">
				    <th colspan="2">
				        <?php $socials = $vendor->socials;     ?>
				        <h4><?php _e( 'Social profile:', 'yith_wc_product_vendors' ) ?></h4>
				    </th>
				</tr>

				<?php foreach( $social_fields as $social => $social_args ) : ?>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_social_<?php echo $social ?>"><?php echo $social_args['label'] ?></label>
				    </th>

				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[socials][<?php echo $social ?>]" id="yith_vendor_social_<?php echo $social ?>" value="<?php echo isset( $socials[ $social ] ) ? $socials[ $social ] : '' ?>" placeholder="http://" /><br />
				    </td>
				</tr>

				<?php endforeach; ?>

				<tr class="form-field">
				    <th>
				        <h4><?php _e( 'Payments:', 'yith_wc_product_vendors' ) ?></h4>
				    </th>
				</tr>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_paypal_email"><?php _e( 'PayPal email address', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[paypal_email]" id="yith_vendor_paypal_email" value="<?php echo $vendor->paypal_email ?>" /><br />
				        <br />
				        <span class="description"><?php _e( 'Vendor\'s PayPal email address where profits will be delivered.', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_bank_account"><?php _e( 'Bank Account (IBAN/BIC)', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="text" class="regular-text" name="yith_vendor_data[bank_account]" id="yith_vendor_bank_account" value="<?php echo $vendor->bank_account ?>" /><br />
				        <br />
				        <span class="description"><?php _e( 'Vendor\'s IBAN/BIC bank account', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_enable_selling"><?php _e( 'Enable sales', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <?php $enable_selling = 'yes' == $vendor->enable_selling ? true : false; ?>
				        <input type="checkbox" name="yith_vendor_data[enable_selling]" id="yith_vendor_enable_selling" value="yes" <?php checked( $enable_selling )?> /><br />
				        <br />
				        <span class="description"><?php _e( 'Enable or disable product sales.', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_skip_review"><?php _e( 'Skip admin review', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <?php $skip_review = 'yes' == $vendor->skip_review ? true : false; ?>
				        <input type="checkbox" name="yith_vendor_data[skip_review]" id="yith_vendor_skip_review" value="yes" <?php checked( $skip_review )?> /><br />
				        <br />
				        <span class="description"><?php _e( 'Allow vendors to add products without admin review', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_enable_featured_products"><?php _e( 'Enable Featured products management', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="checkbox" name="yith_vendor_data[featured_products]" id="yith_vendor_skip_review" value="yes" <?php checked( 'yes', $vendor->featured_products )?> /><br />
				        <br />
				        <span class="description"><?php _e( 'Allow vendors to manage featured products', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>


				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_enable_selling"><?php _e( 'Commission:', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <input type="number" class="regular-text" name="yith_vendor_data[commission]" id="yith_vendor_commission" value="<?php echo esc_attr( $vendor->get_commission() * 100 ); ?>" min="0" max="100" step="0.1" /> %<br/>

				        <br />
				        <span class="description"><?php _e( 'Percentage of the total sale price that this vendor receives.', 'yith_wc_product_vendors' ); ?></span>
				    </td>
				</tr>



				<!-- custom field start -->
				<?php
				  
				  $katgoval=get_woocommerce_term_meta($trmid,'Kategoriento');

				  $cuscatid = $katgoval;
				  $cuscatid = ($cuscatid!='')?$cuscatid:null;


				       $taxnm = 'bstvencategory';
				       $taxarg = array('hide_empty'=>0,'parent' =>0,'orderby'=>'name');
				       $queryarr = get_terms($taxnm,$taxarg);
				       
				       if(count($queryarr)){
				         $selectopt="<select name='yith_vendor_data[Kategorien][]' id='undo_redo' class='form-control' size='13' multiple='multiple'>";

				        foreach ($queryarr as $pkey => $pvalues) {
				            
				            
				            $term = get_term( $pvalues->term_id, $taxnm); 
				            

				            
				            $selectopt.="<option style='color:red' dtid='".$term->term_id."' class='catparent catparent".$chterm->term_id."' value='".$term->term_id."'>".$term->name."</option>";
				            

				            $taxargchild = array('hide_empty'=>0,'parent' =>$term->term_id,'orderby'=>'name','exclude'=>$cuscatid);

				            $taxonomy =get_terms($taxnm,$taxargchild);
				            
				            if(count($taxonomy)){
				                foreach ($taxonomy as $childkey => $childvalues) { 
				                  $selectopt.="<option dtid='".$childvalues->term_id."' class='catchild catchild".$childvalues->term_id."' value='".$childvalues->term_id."'>".$childvalues->name."</option>";
				                }
				            }

				        }
				          $selectopt.="</select>";
				        }

				$selectoptnew='';
				      // $taxnm = 'bstregions';

				       if($cuscatid){
				       $taxtoargselect = array('hide_empty'=>0,'orderby'=>'name','include'=>$cuscatid);
				       $queryarrsel = get_terms($taxnm,$taxtoargselect);
				         $selectoptnew = '';
				       if(count($queryarrsel)){
				         foreach ($queryarrsel as $fromkey => $fromvalue) {
				             $selectoptnew.="<option value='".$fromvalue->term_id."' class='catchild catchild".$fromvalue->term_id."' dtid='".$fromvalue->term_id."'>".$fromvalue->name."</option>";
				         }
				       }
				     }
				       

				   ?>

				<!-- Category section start -->

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_paypal_email"><?php _e( 'Category', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <div class="form-field yith-choosen">  
				<div id="jquery-script-menu">
				<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
				<div class="row">
				                <div class="col-xs-5">
				                    <?php echo $selectopt; ?>
				                </div>
				                
				                <div class="col-xs-2">
				                    <button type="button" id="undo_redo_undo" class="btn btn-primary btn-block">undo</button>
				                    <button type="button" id="undo_redo_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
				                    <button type="button" id="undo_redo_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
				                    <button type="button" id="undo_redo_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
				                    <button type="button" id="undo_redo_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
				                    <button type="button" id="undo_redo_redo" class="btn btn-warning btn-block">redo</button>
				                </div>
				                
				                <div class="col-xs-5">
				                    <select name="yith_vendor_data1[Kategoriento][]" id="undo_redo_to" class="form-control" size="13" multiple="multiple">
				                      <?php echo $selectoptnew; ?>
				                    </select>
				                </div>
				            </div>

				<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
				<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
				<script src="<?php echo plugins_url(); ?>/Bst_Manufacture/js/multiselect.js"></script>
				<script type="text/javascript">
				    jQuery(document).ready(function() {
				        jQuery('#undo_redo').multiselect();


				       jQuery('#submit').click(function(){
				           jQuery('#Beschreibung-html').click();
				       });

				    });
				    
				    </script>

				</div>
				    </td>
				</tr>

				 <!-- category section end --> 
				 <!-- Region section start -->

				<?php
				  
				  $regkatgoval=get_woocommerce_term_meta($trmid,'regionto');

				  $regcuscatid = $regkatgoval;
				  $rcuscatid = ($regcuscatid!='')?$regcuscatid:null;


				       $taxnm = 'bstregions';
				       $taxarg = array('hide_empty'=>0,'parent' =>0,'orderby'=>'name');
				       $queryarr = get_terms($taxnm,$taxarg);
				       
				       if(count($queryarr)){
				         $selectopt="<select name='yith_vendor_data[regions][]' id='undo_redo1' class='form-control' size='13' multiple='multiple'>";

				        foreach ($queryarr as $pkey => $pvalues) {
				            
				            
				            $term = get_term( $pvalues->term_id, $taxnm); 
				            

				            
				            $selectopt.="<option style='color:red' dtid='".$term->term_id."' class='catparent catparent".$chterm->term_id."' value='".$term->term_id."'>".$term->name."</option>";
				            

				            $taxargchild = array('hide_empty'=>0,'parent' =>$term->term_id,'orderby'=>'name','exclude'=>$rcuscatid);

				            $taxonomy =get_terms($taxnm,$taxargchild);
				            
				            if(count($taxonomy)){
				                foreach ($taxonomy as $childkey => $childvalues) { 
				                  $selectopt.="<option dtid='".$childvalues->term_id."' class='catchild catchild".$childvalues->term_id."' value='".$childvalues->term_id."'>".$childvalues->name."</option>";
				                }
				            }

				        }
				          $selectopt.="</select>";
				        }

				$selectoptnew='';
				      // $taxnm = 'bstregions';

				       if($rcuscatid){
				        
				       $taxtoargselect = array('hide_empty'=>0,'orderby'=>'name','include'=>$rcuscatid);
				       $queryarrsel = get_terms($taxnm,$taxtoargselect);
				         $selectoptnew = '';
				       if(count($queryarrsel)){
				         foreach ($queryarrsel as $fromkey => $fromvalue) {
				             $selectoptnew.="<option value='".$fromvalue->term_id."' class='catchild catchild".$fromvalue->term_id."' dtid='".$fromvalue->term_id."'>".$fromvalue->name."</option>";
				         }
				       }
				     }
				       

				   ?>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_paypal_email"><?php _e( 'Region', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <div class="form-field yith-choosen">  
				<div id="jquery-script-menu">
				<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
				<div class="row">
				                <div class="col-xs-5">
				                    <?php echo $selectopt; ?>
				                </div>
				                
				                <div class="col-xs-2">
				                    <button type="button" id="undo_redo1_undo" class="btn btn-primary btn-block">undo</button>
				                    <button type="button" id="undo_redo1_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
				                    <button type="button" id="undo_redo1_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
				                    <button type="button" id="undo_redo1_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
				                    <button type="button" id="undo_redo1_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
				                    <button type="button" id="undo_redo1_redo" class="btn btn-warning btn-block">redo</button>
				                </div>
				                
				                <div class="col-xs-5">
				                    <select name="yith_vendor_data[regionto][]" id="undo_redo1_to" class="form-control" size="13" multiple="multiple">
				                      <?php echo $selectoptnew; ?>
				                    </select>
				                </div>
				            </div>


				<script type="text/javascript">
				    jQuery(document).ready(function() {
				        jQuery('#undo_redo1').multiselect();

				    });


					  jQuery(function() {
					    jQuery( "#from" ).datepicker({
					      defaultDate: "+1w",
					      changeMonth: true,
					      numberOfMonths: 1,
					      onClose: function( selectedDate ) {
					        jQuery( "#to" ).datepicker( "option", "minDate", selectedDate );
					      }
					    });
					    jQuery( "#to" ).datepicker({
					      defaultDate: "+1y",
					      changeMonth: true,
					      numberOfMonths: 1,
					      onClose: function( selectedDate ) {
					        jQuery( "#from" ).datepicker( "option", "maxDate", selectedDate );
					      }
					    });
					  });
  
				    
				    </script>

				</div>
				    </td>
				</tr>

				 <!-- Region section end -->
				<tr class="form-field term-slug-wrap">
				    <th scope="row"><label for="Untertitel">Subtitle(H3)</label></th>
				    <?php $Untertitel=get_woocommerce_term_meta($trmid,'Untertitel',true); ?>
				    <td> <input type="text" class="regular-text" name="yith_vendor_data[Untertitel]" id="yith_vendor_Untertitel" value="<?php echo $Untertitel; ?>" /></td>
				</tr> 

				<tr class="form-field term-slug-wrap">
				<th scope="row"><label for="Untertitel">Font Big Title</label></th>
				    <td>  
				       <select name="yith_vendor_data[Schriftgrosse_titel]" id="yith_vendor_owner" class="ajax_chosen_select_customer" style="width:95%;" data-placeholder="Search for users">
				            <option>Normal</option>
				        </select>
				    </td>
				</tr>


				<tr class="form-field term-slug-wrap">
				    <th scope="row"><label for="Untertitel">Beschreibungeditor</label></th>
				    <td> 
				       <?php
				             $Beschreibungeditor = get_woocommerce_term_meta($trmid,'Beschreibungeditor',true); 
				            $content = urldecode($Beschreibungeditor);
				            $editor_id ='Beschreibungeditor';
				            $settings = array('textarea_name' => 'yith_vendor_data1[Beschreibungeditor]','textarea_rows'=>40);

				            wp_editor( $content, $editor_id, $settings); 
				      ?> 
				    </td>
				</tr>


				<!-- End custom field -->

				<tr class="form-field term-slug-wrap">
				    <th scope="row"><label for="Untertitel">Logo</label></th>
				    <td> 
				     <?php  add_upload_field1( 'span', $vendor->header_logo,'header_logo','Header Logo','false'); ?>
				    </td>
				</tr>

				<tr class="form-field term-slug-wrap">
				    <th scope="row"><label for="Untertitel">Show Logo</label></th>
				    <td> <?php $chkshowlogo=get_woocommerce_term_meta($trmid,'chkshowlogo',true); ?>
					     <input type="hidden" name="yith_vendor_data[chkshowlogo]" value="0" />
	                  	 <label><input <?php if($chkshowlogo==1){echo "checked=checked";} ?> type="checkbox" name="yith_vendor_data[chkshowlogo]" value="1" > Show / Hide logo on vendor listing page</label>
				    </td>
				</tr>

				<tr class="form-field term-slug-wrap">
				    <th scope="row"><label for="Untertitel">Enable Vendor</label></th>
				    <td> <?php $vendorstatus=get_woocommerce_term_meta($trmid,'vendorstatus',true); ?>
					     <input type="hidden" name="yith_vendor_data[vendorstatus]" value="0" />
	                  	 <label><input <?php if($vendorstatus==1){echo "checked=checked";} ?> type="checkbox" name="yith_vendor_data[vendorstatus]" value="1" > Enable/Disable vendors </label>
				    </td>
				</tr>

				<!-- <tr class="form-field term-slug-wrap">
				    <th scope="row"><label for="Untertitel">Gallery</label></th>
				    <td> 
				     <?php
				    //   add_upload_field1( 'span', $vendor->header_gallery,'header_gallery','Gallery','true'); ?>
				    </td>
				</tr> -->
				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_skip_review"><?php _e( 'Registration', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <?php
                           $regfrom=get_woocommerce_term_meta($trmid,'regfrom',true);
                           $regto=get_woocommerce_term_meta($trmid,'regto',true);

				        ?>
				        From <input type="text" id="from" name="yith_vendor_data[regfrom]" value="<?php echo $regfrom; ?>"> to <input type="text" id="to" name="yith_vendor_data[regto]" value="<?php echo $regto; ?>">
				    </td>
				</tr>

				<tr class="form-field">
				    <th scope="row" valign="top">
				        <label for="yith_vendor_registration_date"><?php _e( 'Registration date:', 'yith_wc_product_vendors' ); ?></label>
				    </th>
				    <td>
				        <?php echo $vendor->get_registration_date( 'display' ) ?>
				    </td>
				</tr>

             </table>
    </div>
    <!-- tab 1end -->
    <!-- tab 2 start -->
     <div id="exec1" class="tab_content">
		      <table>
		      				<tr class="form-field term-slug-wrap">
		                <th scope="row"><label for="Untertitel">gallery</label></th>
		                <td  class='gallerycontainer'> 
		                 <?php
		                    
		                    $cpts = apply_filters('images_cpt', array('yith_shop_vendor'));
		                    $screen = get_current_screen();

							/*foreach($cpts as $cpt){
								add_meta_box('imagesliees', __('Add Photos'), "imagesliees", null, 'normal', 'core');
							}*/

							imagesliees($tgid);


		                    ?>
		                    <div class='multicontainer'></div>
		                </td>
		            </tr>
		      			</table>
     </div>
     <!-- tab 2 end -->
     <!-- tab 3 start -->
     <div id="exec2" class="tab_content">
       <table>
       <?php $meta_value = boilerclassp();
         $meta_value[0]['termetaid'] = $tgid->term_id; ?>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="Untertitel">Snippets</label></th>
                <td> 
                 <?php
                    
                    foreach( $meta_value as $meta_b )
                    {
                       $objMetabox = new ADD_META_BOX1( $meta_b );
                        $objMetabox->show();
                    }


                    ?>
                </td>
            </tr>
         </table>
     </div>
     <div id="exec3" class="tab_content">
        <table>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="Untertitel">Methods</label></th>
                <td> 
                  <?php
                  	include_once(ABSPATH.'wp-content/plugins/Bst_Manufacture/shippingmodule/Bst_shippingclass.php');
                   ?>
                </td>
            </tr>
         </table>
     </div>
     <div id="exec4" class="tab_content">
        <table>
            <tr class="form-field term-slug-wrap">
                <th scope="row" colspan="2"><label for="Untertitel">Payment Acceptance(Enable / Disable)</label></th>
                </tr>
                <tr>
                <td></td>
                <td> 
                  <div>
                    <?php
                    	global $shippingrest;
                    	
                    	$paymentarr = unserialize($shippingrest[0]->payment);

                    	
                     ?>
                     <input type="hidden" name="payment[creditcard]" value="0" />
                  	 <label><input <?php if($paymentarr['creditcard']==1){echo "checked=checked";} ?> type="checkbox" name="payment[creditcard]" value="1" > Credit Card</label>
                  </div>
                  <div>
                     <input type="hidden" name="payment[paypal]" value="0" />
                  	 <label><input <?php if($paymentarr['paypal']==1){echo "checked=checked";} ?> type="checkbox" name="payment[paypal]" value="1"> Paypal</label>
                  </div>
                  <div>
                     <input type="hidden" name="payment[billpayment]" value="0" />
                  	 <label><input <?php if($paymentarr['billpayment']==1){echo "checked=checked";} ?> type="checkbox" name="payment[billpayment]" value="1"> Bill Payment</label>
                  </div>
                  <div>
                   <input type="hidden" name="payment[advancepayment]" value="0" />
                  	 <label><input <?php if($paymentarr['advancepayment']==1){echo "checked=checked";} ?> type="checkbox" name="payment[advancepayment]" value="1"> Advance Payment</label>
                  </div>
                </td>
            </tr>
         </table>
     </div>
     <!-- tab 3 end -->
</div>
     



<script type="text/javascript">
      jQuery(document).ready(function(){
        jQuery( "#top-level" ).tabs(  );  //{ heightStyle: "fill" }
      })
    
  </script>
<!-- container end -->
    </td>
</tr>


         <!-- end -->
            

         <?php
    }

/**
B) SAVE METABOX 
*/
add_action('save_post', 'save_image_metabox'); 
function save_image_metabox($post_ID){ 
	// on retourne rien du tout s'il s'agit d'une sauvegarde automatique
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
    
   	$list_images = list_my_images_slots();
    foreach($list_images as $k => $i){
	    if ( isset( $_POST[$k] ) ) {
			check_admin_referer('image-liee-save_'.$_POST['post_ID'], 'image-liee-nonce');
			update_post_meta($post_ID, $i, esc_html($_POST[$k])); 
		}
	}
}

/**	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// C) FUNCTIONS BUILDING THE META BOX ↓
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
/**
// IMAGES
*/
function imagesliees($post){


	$tagid = $post->term_id;
	$list_images = list_my_images_slots();

	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( 'quicktags' );
	wp_enqueue_script( 'jquery-ui-resizable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-button' );
	wp_enqueue_script( 'jquery-ui-position' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_script( 'wpdialogs' );
	wp_enqueue_script( 'wplink' );
	wp_enqueue_script( 'wpdialogs-popup' );
	wp_enqueue_script( 'wp-fullscreen' );
	wp_enqueue_script( 'editor' );
	wp_enqueue_script( 'word-count' );

	//wp_enqueue_script( 'img-mb', plugin_dir_url().'Bst_Manufacture/js/multiup/get-images.js', array( 'jquery','media-upload','thickbox','set-post-thumbnail' ) );
	wp_enqueue_style( 'customsimg-mb', plugin_dir_url().'Bst_Manufacture/css/multiup.css');
	wp_enqueue_style( 'thickbox' );

	wp_nonce_field( 'image-liee-save_'.$post->term_id, 'image-liee-nonce');

	
	$z =1;
	
	$imgstag = get_woocommerce_term_meta($tagid,'upimage',true);
	$imgaidrr = explode(',',$imgstag);

	foreach($imgaidrr as $k=>$i){
		$meta = $i;
		$no=$k+1;
		echo '<div id="droppable'.$no.'">';
		$img = (isset($meta)) ? '<img src="'.wp_get_attachment_thumb_url($meta).'" width="100" height="100" alt="" draggable="false">' : '';
		echo '<div class="image-entry" draggable="true">';
		echo '<input type="hidden" name="upimage[]" id="image'.$no.'" class="id_img" data-num="'.$no.'" value="'.$meta.'">';
		echo '<div class="img-preview" data-num="'.$no.'">'.$img.'</div>';
		$onl='';
		/*if($no != 1){*/ $onl='onclick="addImage()"'; /*}*/
		echo '<a '.$onl.' href="javascript:void(0);" class="multiimageupload" data-num="'.$no.'">'._x('Add New','file').'</a><a onclick="deletImage('.$meta.','.$no.')" href="javascript:void(0);" class="delbutton" data-num="'.$no.'">'.__('Delete').'</a>';
		echo '</div>';
		$z++;
		echo '</div>';
	}
	
	?>

	<script>jQuery(document).ready(function($){
		function reorderImages(){
			//reorder images
			jQuery('#droppable .image-entry').each(function(i){
				//rewrite attr
				var num = i+1;
				jQuery(this).find('.get-image').attr('data-num',num);
				jQuery(this).find('.del-image').attr('data-num',num);
				jQuery(this).find('div.img-preview').attr('data-num',num);
				var $input = jQuery(this).find('input');
				$input.attr('name','image'+num).attr('id','image'+num).attr('data-num',num);
			});
		}

		if('draggable' in document.createElement('span')) {
			function handleDragStart(e) {
			  this.style.opacity = '0.4';  // this / e.target is the source node.
			}

			function handleDragOver(e) {
			  if (e.preventDefault) {
			    e.preventDefault(); // Necessary. Allows us to drop.
			  }
			  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
			  return false;
			}

			function handleDragEnter(e) {
			  // this / e.target is the current hover target.
			  this.classList.add('over');
			}

			function handleDragLeave(e) {
				var rect = this.getBoundingClientRect();
	           // Check the mouseEvent coordinates are outside of the rectangle
	           if(e.x > rect.left + rect.width || e.x < rect.left
	           || e.y > rect.top + rect.height || e.y < rect.top) {
	               this.classList.remove('over');  // this / e.target is previous target element.
	           }
			}

			function handleDrop(e) {
			  // this / e.target is current target element.
			  if (e.stopPropagation) {
			    e.stopPropagation(); // stops the browser from redirecting.
			  }
			  // Don't do anything if dropping the same column we're dragging.
			  if (dragSrcEl != this) {
			    // Set the source column's HTML to the HTML of the column we dropped on.
			    dragSrcEl.innerHTML = this.innerHTML;
			    this.innerHTML = e.dataTransfer.getData('text/html');
			    reorderImages();
			  }
			  // See the section on the DataTransfer object.
			  return false;
			}

			function handleDragEnd(e) {
			  // this/e.target is the source node.
			  this.style.opacity = '1';
			  [].forEach.call(cols, function (col) {
			    col.classList.remove('over');
			  });
			}

			var dragSrcEl = null;

			function handleDragStart(e) {
			  // Target (this) element is the source node.
			  this.style.opacity = '0.4';
			  dragSrcEl = this;
			  e.dataTransfer.effectAllowed = 'move';
			  e.dataTransfer.setData('text/html', this.innerHTML);
			}

			var cols = document.querySelectorAll('#droppable .image-entry');
			[].forEach.call(cols, function(col) {
			  col.addEventListener('dragstart', handleDragStart, false);
			  col.addEventListener('dragenter', handleDragEnter, false);
			  col.addEventListener('dragover', handleDragOver, false);
			  col.addEventListener('dragleave', handleDragLeave, false);
			  col.addEventListener('drop', handleDrop, false);
	  		  col.addEventListener('dragend', handleDragEnd, false);
			});
		}else{
			  jQuery( "#droppable" ).sortable({
			  	opacity: 0.4, 
			    cursor: 'move',
			    update: function(event, ui) {
			    	reorderImages()
			    }
			  });
		}







   /* 
 * Function to upload media
 */

 // Uploading files
            



});

function deletImage(id,divno){
	
	var total =jQuery('.delbutton').length;
   	if(total>1){
      jQuery("#droppable"+divno).remove();
   	}else if(total==1){
   		jQuery("#droppable"+divno+" img").attr('src','');
   	}
   }

function addImage(){
file_frame='';

	// event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php echo __( "Choose an image", "yith_wc_product_vendors" ) ?>',
                    button: {
                        text: '<?php echo __( "Use image", "yith_wc_product_vendors" ) ?>',
                    },
                    multiple: true
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {

                    var selection = file_frame.state().get('selection');
                    var objselection = selection.toJSON();
                    k = jQuery('.cimage-entry').length;
                    
                   if(k==1 && jQuery('#droppable1 img').attr('src')==''){

                   	   

					  	   for (i = 0; i < objselection.length; i++) {
						    idval = objselection[i].id;
						    idurl = objselection[i].sizes.thumbnail.url;
                            k=k+1;
					    	divcontain1 = "<div  class='cimage-entry'><input type='hidden' value='"+idval+"' data-num='"+idval+"' class='id_img' id='image1' name='upimage[]'><div data-num='"+idval+"' class='img-preview'><img height='100' width='100' draggable='false' alt='' src='"+idurl+"'></div><a onclick='addImage()' data-num='1' class='multiimageupload' href='javascript:void(0);''>Add New</a><a data-num='1' class='delbutton' href='javascript:void(0);' onclick='deletImage("+idval+",1)'>Delete</a></div>";  
                           jQuery('.gallerycontainer #droppable1').html(divcontain1);
					    }

					  

                   }
                   else{

                    for (i = 0; i < objselection.length; i++) {
					    idval = objselection[i].id;
					    idurl = objselection[i].sizes.thumbnail.url;

					    
                            k=k+1;
					    	divcontain = "<div id='droppable"+k+"' class=''><div class='cimage-entry'><input type='hidden' value='"+idval+"' data-num='"+k+"' class='id_img_c' id='image"+k+"' name='upimage[]'><div data-num='"+k+"' class='img-preview'><img height='100' width='100' alt='' src='"+idurl+"'></div><a data-num='"+idval+"' class='multiimageupload' href='javascript:void(0);' onclick='addImage()'>Add New</a><a data-num='"+k+"' class='delbutton' onclick='deletImage("+idval+","+k+")' href='javascript:void(0);'>Delete</a></div></div> ";
                           jQuery('.multicontainer').append(divcontain);
					    
					}
				   }
 
                });

                // Finally, open the modal.
                file_frame.open();

}   


</script>

	<style type="text/css">
	[draggable] {
	  -moz-user-select: none;
	  -khtml-user-select: none;
	  -webkit-user-select: none;
	  user-select: none;
	}
	.img-preview{
		position:relative;
		display:block;
		width:100px;
		height:100px;
		background:#efefef;
		border:1px solid #FFF;
	}
	.img-preview img{
		position:absolute;
		top:0;
		left:0;
	}
	.image-entry{
		float:left;
		margin:0 10px 10px 0;
		border:2px solid #ccc;
		padding:10px;
		background:#FFF;
	}
	.image-entry:last-child{margin-right:0;}
	.image-entry.over{
		border: 2px dashed #000;
	}
	.get-image,.del-image{
		margin-top:10px !important;
		display:block !important;
	}
	</style>
	<?php
}

/**
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 5. PROCEDURAL FUNCTIONS ↓
* @uses get_images_ids (FUNCTION) to retrieve linked images IDs
* @param thumbnail (BOOL) if true, prepend the thumbnail image Id of the current post at the front of the returned array
* @param id (INT) if defined, set the target post id
* @return ARRAY

* @uses get_images_src (FUNCTION) to retrieve linked images sources an dimentions
* @param size (STRING) the queried size
* @param thumbnail (BOOL) if true, prepend thumbnail image source of the current post at the front of the returned array
* @param id (INT) if defined, set the target post id
* @return ARRAY

* @uses get_multi_images_src (FUNCTION) to retrieve linked images IDs
* @param small (STRING) the first queried size
* @param large (STRING) the second queried size
* @param thumbnail (BOOL) if true, prepend thumbnail image sources of the current post at the front of the returned array
* @param id (INT) if defined, set the target post id
* @return ARRAY
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
// ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
function get_images_ids($thumbnail = false, $id = false){
	global $post;
	$the_id = ($id) ? $id : $post->ID;

	$list_images = list_my_images_slots( get_post_type( $id ) );

	$a = array();
	foreach ($list_images as $key => $img) {
		if($i = get_post_meta($the_id,$img,true))
			$a[$key] = $i;
	}
	if($thumbnail){
		$thumb_id = get_post_thumbnail_id($the_id);
		if(!empty($thumb_id)) array_unshift($a, get_post_thumbnail_id($the_id));
	} 
	return $a;
}

function get_images_src($size = 'medium',$thumbnail = false, $id = false){
	if($id)
		$images = $thumbnail ? get_images_ids(true,$id) : get_images_ids(false,$id);
	else 
		$images = $thumbnail ? get_images_ids(true) : get_images_ids();
	$o = array();
	foreach($images as $k => $i)
		$o[$k] = wp_get_attachment_image_src($i, $size);
	return $o;
}

function get_multi_images_src($small = 'thumbnail',$large = 'full',$thumbnail = false, $id = false){
	if($id)
		$images = $thumbnail ? get_images_ids(true,$id) : get_images_ids(false,$id);
	else 
		$images = $thumbnail ? get_images_ids(true) : get_images_ids();
	$o = array();
	foreach($images as $k => $i)
		$o[$k] = array(wp_get_attachment_image_src($i, $small),wp_get_attachment_image_src($i, $large));
	return $o;
}