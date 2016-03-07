<!-- FOOTER --></div>	
	<footer>
		<h2 class="hidden">Der Footer</h2>

		<!-- SECTION: INHALT DES FOOTERS -->
    	<section class="wrapper">
			<h3 class="hidden">Inhalt des Footers</h3>
            
            <div id="breadcrumb"><?php if (function_exists('nav_breadcrumb')) nav_breadcrumb(); ?></div>
            
        	<div id="footer_regular">
            
				<!-- SPALTE: LINKS -->
            	<div class="column">
					<?php dynamic_sidebar( 'Footer 1' ); ?>
				</div>
            	<!-- / SPALTE -->
            
            	<!-- SPALTE: 2 VON LINKS -->        
				<div class="column">
					<?php dynamic_sidebar( 'Footer 2' ); ?>
				</div>
            	<!-- / SPALTE --> 
            
            	<!-- SPALTE: 2 VON RECHTS -->   
            	<div class="column">
					<?php dynamic_sidebar( 'Footer 3' ); ?>
				</div>
            	<!-- / SPALTE --> 
            
            </div>

			<div id="footer_mobile">
			
				<div class="footer_mobile_container">
  					<div class="footer-accordion">
    					<dl>
      						<dt>
      						<div class="nowidgetcontent"><a href="#accordion1" aria-expanded="false" aria-controls="accordion1" class="accordion-title accordionTitle js-accordionTrigger"><?php dynamic_sidebar( 'Footer 1' ); ?></a></div>
              				</dt>
    					</dl>
    					
    					<dl>
      						<dt>
      						<div class="nowidgetcontent"><a href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="accordion-title accordionTitle js-accordionTrigger"><?php dynamic_sidebar( 'Footer 2' ); ?></a></div>
              				</dt>
    					</dl>
    					
    					<dl>
      						<dt>
      						<div class="nowidgetcontent"><a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger"><?php dynamic_sidebar( 'Footer 3' ); ?></a></div>
              				</dt>
    					</dl>
    					
  					</div>
				</div>

			</div>
			        
        </section> 
    	<!-- / SECTION 4 -->   

          
    </footer>
<!-- / FOOTER -->

<?php wp_footer(); ?>  


<!-- Hamburger Menu -->
<script type="text/javascript">

	$(function() {
		$('nav.primary').addClass('regular');
		$('<div id="hamburger" />').appendTo('div#pnav');
		$('<div class="responsive-nav-icon" />').appendTo('#hamburger');
		$('<div class="responsive-nav-close" />').appendTo('#hamburger');
		$('<div id="overlay" />').insertAfter('footer');
		$('.responsive-nav-close').hide();
	
		// Navigation Slide In
		$('.responsive-nav-icon').click(function() {
			$('nav.primary').addClass('slide-in');
			$('html').css("overflow", "hidden");
			$('.responsive-nav-close').show();
			$('.responsive-nav-icon').hide();
			$('#paddles').hide();
			$('#overlay').show();
			$('nav.primary').addClass('responsive');
			return false;
		});

	// Navigation Slide Out
		$('#overlay, .responsive-nav-close').click(function() {
			$('nav.primary').removeClass('slide-in');
			$('.responsive-nav-close').hide();
			$('.responsive-nav-icon').show();
			$('#overlay').hide();
			$('#paddles').show();
			$('html').css("overflow", "auto");
			$('nav.primary').removeClass('responsive');
			$('nav.primary').addClass('regular');
			return false;
		});
	});
	
	
	// Mobile Footer
	(function(){
		var d = document,
		accordionToggles = d.querySelectorAll('.js-accordionTrigger'),
		setAria,
		setAccordionAria,
		switchAccordion,
  		touchSupported = ('ontouchstart' in window),
  		pointerSupported = ('pointerdown' in window);
  
  		skipClickDelay = function(e){
    		e.preventDefault();
    		e.target.click();}

		setAriaAttr = function(el, ariaType, newProperty){
			el.setAttribute(ariaType, newProperty);};
			
		setAccordionAria = function(el1, el2, expanded){
			switch(expanded) {
      			case "true":
      				setAriaAttr(el1, 'aria-expanded', 'true');
      				setAriaAttr(el2, 'aria-hidden', 'false');
      				break;
      			case "false":
      				setAriaAttr(el1, 'aria-expanded', 'false');
      				setAriaAttr(el2, 'aria-hidden', 'true');
      				break;
      			default:
					break;}};

	switchAccordion = function(e) {
  		console.log("triggered");
		e.preventDefault();
			var thisAnswer = e.target.parentNode.nextElementSibling;
			var thisQuestion = e.target;
			if(thisAnswer.classList.contains('is-collapsed')) {
				setAccordionAria(thisQuestion, thisAnswer, 'true');
				} else {
				setAccordionAria(thisQuestion, thisAnswer, 'false');}
  			thisQuestion.classList.toggle('is-collapsed');
  			thisQuestion.classList.toggle('is-expanded');
			thisAnswer.classList.toggle('is-collapsed');
			thisAnswer.classList.toggle('is-expanded');
  			thisAnswer.classList.toggle('animateIn');};
  			
			for (var i=0,len=accordionToggles.length; i<len; i++) {
				if(touchSupported) {
      				accordionToggles[i].addEventListener('touchstart', skipClickDelay, false);}
    			if(pointerSupported){accordionToggles[i].addEventListener('pointerdown', skipClickDelay, false);}
    				accordionToggles[i].addEventListener('click', switchAccordion, false);}
		})();
</script>

</body>
<!-- / BODY -->
</html>
