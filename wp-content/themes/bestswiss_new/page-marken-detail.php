<?php get_header(); ?>
<!-- BODY -->

<!-- SEITEN-WRAP -->
<div class="pagewrap marken-detail">

<!-- LEFT COL -->
	<div class="marken-detail-col-left">
		<div class="category-header"><h3>Marken-Name</h3></div>

	<!-- CONTENT -->
		<section id="sitecontent">
		<!-- LOOP -->
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
	<!-- IMAGE -->
		<div class="marken-detail-image"><img src="http://bsd2.tradehouse.ch/wp-content/uploads/2016/03/Bildschirmfoto-2016-03-01-um-19.00.27.png"></img></div>

	<!-- CONTENT -->
		<div class="marken-detail-content">

		<!-- GESCHICHTE -->	
		<h5>Geschichte</h5>
		<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
	
		<!-- PRODUKTE -->	
		<h5>Produkte</h5>
		<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
	
		<!-- HIGHIGHT -->	
		<h5>Highlight</h5>
		<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</p>

		<!-- BEZUGSQUELLE -->	
		<h5>Bezugsquelle</h5>
		<p>Link to Vendors-Category in Shop</p>
		
		<!-- FAZIT -->	
		<h5>Fazit Bestswiss</h5>
		<p class="fazit">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et.</p>	

		<!-- KONTAKT -->	
		<h5>Kontakt</h5>
		<p>Name Company<br>Adress 1<br>Adress 2<br>Zip City</p>
		<a href=#>www.company.ch</a>
	
		</div>
	<!-- / CONTENT -->
    	
		<?php endwhile; endif;?>
		</section>
	</div> 

<!-- RIGHT COL -->
	<div class="marken-detail-col-right">
		<div class="category-header"><h3>Produkte</h3></div>
	
		<!-- IMAGE -->
		<div class="marken-detail-produkt-image"><a href=# title="Link to Product in Shop"><img src="http://bsd2.tradehouse.ch/wp-content/uploads/2016/03/Bildschirmfoto-2016-03-01-um-19.00.27.png"></img></a></div>

		<!-- IMAGE -->
		<div class="marken-detail-produkt-image"><a href=# title="Link to Product in Shop"><img src="http://bsd2.tradehouse.ch/wp-content/uploads/2016/03/Bildschirmfoto-2016-03-01-um-19.00.27.png"></img></a></div>

		<!-- IMAGE -->
		<div class="marken-detail-produkt-image"><a href=# title="Link to Product in Shop"><img src="http://bsd2.tradehouse.ch/wp-content/uploads/2016/03/Bildschirmfoto-2016-03-01-um-19.00.27.png"></img></a></div>

		<!-- IMAGE -->
		<div class="marken-detail-produkt-image"><a href=# title="Link to Product in Shop"><img src="http://bsd2.tradehouse.ch/wp-content/uploads/2016/03/Bildschirmfoto-2016-03-01-um-19.00.27.png"></img></a></div>

		<!-- IMAGE -->
		<div class="marken-detail-produkt-image"><a href=# title="Link to Product in Shop"><img src="http://bsd2.tradehouse.ch/wp-content/uploads/2016/03/Bildschirmfoto-2016-03-01-um-19.00.27.png"></img></a></div>

	</div>

</div>
<?php get_footer(); ?>