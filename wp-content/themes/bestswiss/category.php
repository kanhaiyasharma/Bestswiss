<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="catpage">

<!-- KATEGORIE-TITEL -->
<h2><?php single_cat_title(); ?></h2>

<!-- KATEGORIE-BESCHREIBUNG -->
<?php if ( category_description() ) : ?>
	<h4><?php echo category_description(); ?></h4>
<?php endif; ?>

<!-- CONTENT -->
<section id="sitecontent">

	<!-- LOOP -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="category-listing">
		<!-- IMAGE -->
		<section class="post-image">
		<?php the_post_thumbnail('thumbnail');?>
		</section>
	
		<!-- HEADLINE -->
		<section class="category-listing-headline">
			<h2 class="hidden">Spacer</h2>
        	<a href="<?php the_permalink() ?>"><h1><?php the_title();?></h1></a>
    	</section>
    
    	<!-- POST-META 
    	<div class="post-meta">
    		<div class="datum"><?php the_date(); ?></div>
    		<div class="autor"><?php the_author(); ?></div>
   	 	</div> -->

    	<!-- POST-INHALT / MIT AUSZUG -->
    	<section class="content">
    		<!--<p class="readmore"><?php the_content();?></p>-->
    		<p><a href="<?php the_permalink() ?>"><?php the_excerpt();?></p>
    	</section>
    
    	<!-- POST-INHALT / OHNE AUSZUG MIT WEITERLESEN
    		<section id="content">
    		<p><?php the_content('Weiterlesen')?></p>
    	</section> -->
	</div>
	<?php endwhile; endif;?>

	<!-- PAGINATION -->
	<div class="pagination">
	<p><?php posts_nav_link(' | ','&laquo; Neuere Artikel','Ältere Artikel &raquo;'); ?></p>
	</div>

</section>    

</div>
<?php get_footer(); ?>