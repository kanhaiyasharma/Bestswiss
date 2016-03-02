<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="pagewrap">

<!-- KATEGORIE-TITEL -->
<div class="category-header"><h3>Will be Home</h3></div>
<br>
<br>
<p> Notice: </p>
<li> Journal Category Listing = Blog-Archive </li>
<li> Journal Category Listing -> for some reasons the images are resized here (no idea why). But not important on this DEV-Server. For ongoing work by Timo, please check bsd2.tradehouse.ch</li>
<li> Journal Single Page -> by Timo / in progress </li>
<li> Marken means Vendors </li>
<li> Marken A-Z Listing -> for Kanhaiya / Tmpl-Files are commented, CSS (LESS) is set </li>
<li> Marken A-Z Listing -> Links are active and will guide to Marken-Detail Page </li>
<li> Marken Detail Page -> for Kanhaiya / Tmpl-Files are commented, CSS (LESS) is set </li>
<li> Disregard Responsive view so far -> will be completed step by step </li>
<li> No cache running so far</li>
<li> LESS-Files will finally be put together in a single file.</li>
<li> No usage of Visual Composer so far. </li>
<br>
<p> IMPORTANT: </p>
<p> functions.php and all other JS-files are subject to theming by Timo. Please do not adjust those files! If there is anything you need to enque, please go via header.php and kindly advise Timo afterwards.</p>
<br>
<br>
<br>
<br>

<!-- CONTENT -->
<section id="sitecontent">
	<!-- LOOP -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  	<?php endwhile; endif;?>
</section>      
<?php get_footer(); ?>