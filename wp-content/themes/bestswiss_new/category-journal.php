<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="catpage">

<!-- KATEGORIE-TITEL -->
<div class="category-header"><h3>Aktuelle Beiträge</h3></div>

<!-- CONTENT -->
<section id="sitecontent">

	<!-- LOOP -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="category-listing">
		<!-- IMAGE -->
		<section class="post-image">
		<?php the_post_thumbnail('thumbnail');?>
		</section>
		
		<!-- POST-META -->
    	<div class="post-meta">
    		<div class="datum"><?php the_date(); global $previousday; $previousday = null; ?></div>
   	 	</div>
	
		<!-- HEADLINE -->
		<section class="category-listing-headline">
			<h2 class="hidden">Spacer</h2>
        	<a href="<?php the_permalink() ?>"><h1><?php the_title();?></h1></a>
    	</section>

    	<!-- POST-INHALT / MIT AUSZUG -->
    	<section class="content">
    		<p><a href="<?php the_permalink() ?>"><?php the_excerpt();?></p>
    	</section>
    
	</div>
	<?php endwhile; endif;?>

</section>  

<!-- PAGINATION -->
	<div class="pagination">
	<p><?php posts_nav_link(' | ','<span class="previous">Vorige Journaleinträge anzeigen</span>','<span class="next">Mehr Journaleinträge anzeigen</span>'); ?></p>
	</div>

</div>
<?php get_footer(); ?>