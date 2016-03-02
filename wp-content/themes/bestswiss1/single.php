<?php get_header(); ?>
<!-- BODY -->

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
	<section class="spacer-1">
		<h2 class="hidden">Spacer</h2>
        <h1><?php the_title();?></h1>
    </section>

	<!-- POST-META -->
    	<div class="post-meta">
    		<div class="datum"><?php the_date(); ?></div>
    		<div class="autor"><?php the_author(); ?></div>
    		<div class="category"><?php the_category(', '); ?></div>
    		<div class="tags"><?php the_tags('', ' &bull; ', ''); ?></div>
   	 	</div>
   	 	
    <!-- POST-INHALT -->
    <section id="content">
    	<p><?php the_content();?></p>
    </section>
<?php endwhile; endif;?>
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