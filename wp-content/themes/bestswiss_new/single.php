<?php get_header(); ?>
<!-- BODY -->

<div id="journal">

	<!-- SIDEBAR LEFT
		<section id="sidebar" class="left">
			<?php get_sidebar( 'left' ); ?>
	
		<?php if ( is_sidebar_active( 'left' ) ) { ?>
			<div id="sidebar_left">
 				<?php dynamic_sidebar('left');?>
			</div>
		<?php } ?>
		</section> -->


<!-- CONTENT -->
	<section id="sitecontent">
		<!-- LOOP -->
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<!-- HEADLINE -->
		<section class="journal-headline">
        	<h1><?php the_title();?></h1>
    	</section>
    	
    	<!-- AUSZUG -->
		<section class="journal-auszug">
        	<p><?php the_excerpt();?></p>
    	</section>
    	
    	<!-- TRENNER -->
    	<div class="trenner"></div>
   	 	
    	<!-- POST-INHALT -->
    	<section id="content">
    		<p><?php the_content();?></p>
    	</section>
    
    	<!-- POST-META -->
    	<div class="post-meta">
    	    <div class="datum"><?php the_date(); ?></div>
    		<div class="category">Ein Beitrag aus der Kategorie: <?php the_category(', '); ?></div>
    		<div class="tags"><?php the_tags('', ' &bull; ', ''); ?></div>
    		<div class="autor">Redaktion: <a href="<?php bloginfo('url');?>">bestswiss.ch</a>, <?php the_author_posts_link(); ?></div>
   	 	</div>
   	 	

		<!-- NEXT POST -->
		<?php if(get_adjacent_post(true, '', false)) { ?>
   	 		<div class="nextpost">
   	 			<div>Nächster Artikel<div>
   	 			<div><?php next_post_link('%link'); ?></div>
   	 		</div>
		<?php } else { ?>
			<div class="nextpost">
				<div><a class="newsletter" href="<?php bloginfo('url'); ?>/newsletter">Informieren, wenn neue Artikel vorhanden sind.</a></div>
			</div>
		<?php } ?>
   	 	
    
    
<?php endwhile; endif;?>
</section>    

<!-- SIDEBAR RIGHT 
	<section id="sidebar" class="right" style="float:right;">
		<?php get_sidebar( 'right' ); ?>
	
	<?php if ( is_sidebar_active( 'right' ) ) { ?>
		<div id="sidebar_right">
 		<?php dynamic_sidebar('right');?>
		</div>
	<?php } ?>
	</section> -->

</div>
<?php get_footer(); ?>