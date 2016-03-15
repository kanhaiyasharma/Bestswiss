<?php
/*
 * Template Name: Vendor Listing
 */
?>
<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="pagewrap marken">

<!-- TITEL -->
	<div class="category-header"><h3><?php echo get_the_title(); ?></h3></div>

<!-- CONTENT -->
	<section id="sitecontent">
	<?php
     $currentdate= date('m/d/Y');
     global $wpdb;
     $wpterid=$wpdb->get_col("SELECT woocommerce_term_id  FROM `".$wpdb->prefix."woocommerce_termmeta` WHERE `meta_key` LIKE 'regto' and STR_TO_DATE(`meta_value`,'%m/%d/%Y') >= STR_TO_DATE('".$currentdate."','%m/%d/%Y') ");
     
	   $argtxt=array('orderby'=>'name','order'=>'ASC','hide_empty'=>0,'include'=>$wpterid );
     $taxlist = get_terms('yith_shop_vendor',$argtxt);
     
     $alphaval = range('A','Z');
       
       
       $col=0;
       
      for($a=ord('A');$a<=ord('Z');$a++){
        $currentAlpha = chr($a);
        if($col==0){
            $vendorlistcolumn.='<div class="marken-listing-col">';
        }elseif($col%10==0){
            $vendorlistcolumn.='</div><div class="marken-listing-col">';
        }

        $vendorlistcolumn.="<div class='marken-index'>".$currentAlpha."</div>"; 
        $vendorlistcolumn.="<div class='marken-liste'><ul>";

        foreach ($taxlist as $key => $value) {

            $stringfletter = ucfirst(substr($value->name,0,1));
            $getlogocheckval=get_woocommerce_term_meta($value->term_id,'chkshowlogo',true);

            if($currentAlpha == $stringfletter){
                $term_link = get_term_link($value);
                if($getlogocheckval==0){
                 $vendorlistcolumn.="<li><a href='".esc_url($term_link)."'>".$value->name."</a></li>"; 
                }else{
                    $getImageurl=get_woocommerce_term_meta($value->term_id,'header_logo',true);
                    $attacharray = wp_get_attachment($getImageurl);
                     $imagesrc = wp_get_attachment_image_src($getImageurl , 'single-post-thumbnail' );
                     $imgalt = ($attacharray['alt']!='')?$attacharray['alt']:$value->name;
                    $vendorlistcolumn.="<span class='marken-listing-logo'><a href='".esc_url($term_link)."'><img alt='".$imgalt."' src='".$imagesrc[0]."'/></a></span>"; 
                }
            }
         }
         $vendorlistcolumn.="</ul></div>";
         $col++;
      }

       $vendorlistcolumn.='</div>';
       echo $vendorlistcolumn;
	?>

	</section>
</div> 
<?php get_footer(); ?>