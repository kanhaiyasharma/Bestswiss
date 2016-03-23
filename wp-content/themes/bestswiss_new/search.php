<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="catpage">

<!-- SIDEBAR LEFT
	<section id="sidebar" class="left">
		<?php get_sidebar( 'left' ); ?>
	
	<?php if ( is_sidebar_active( 'left' ) ) { ?>
		<div id="sidebar_left">
 		<?php dynamic_sidebar('left');?>
		</div>
	<?php } ?>
	</section> -->

<!-- KATEGORIE-TITEL -->
<h2>Sie suchten nach: <?php echo get_search_query(); ?></h2>

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

<!-- SIDEBAR RIGHT  -->
	<section id="sidebar" class="right" style="float:right;">
		<?php get_sidebar( 'right' ); ?>
	
	<?php if ( is_sidebar_active( 'right' ) ) { ?>
		<div id="sidebar_right">
 		<?php dynamic_sidebar('right');?>
		</div>
	<?php } ?>
	</section>

<?php get_footer(); ?>