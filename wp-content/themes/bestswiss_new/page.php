<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="pagewrap">

<!-- KATEGORIE-TITEL -->
<div class="category-header"><h3>Listenansicht</h3></div>

<!-- CONTENT -->
<section id="sitecontent">
	<!-- LOOP -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


    <!-- POST-INHALT -->
    <section id="content">
    	<p><?php the_content();?></p>
    </section> 
    
	<?php endwhile; endif;?>

</section>    

<!-- SIDEBAR RIGHT
	<section id="sidebar" class="right">
		<?php get_sidebar( 'right' ); ?>
	</section> -->

<?php get_footer(); ?>