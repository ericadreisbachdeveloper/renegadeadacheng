<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
</div><!-- /.wrapper -->



<footer class="site-footer">



	<!-- if is single, show navigation -->
	<?php if(is_single()) { include(locate_template('template/pagination_single.php')); } ?>


	<!-- show page-to-page navigation -->
	<?php if(!is_front_page()) { include(locate_template('template/pagination_from_menu.php')); }  ?>


	<div class="container-fluid footer-social-container">
		<div class="container">
		  <div class="row footer-widgets-row">
				<?php if(is_active_sidebar('Footer Widgets')) { dynamic_sidebar( 'Footer Widgets' ); } ?>
		  </div>
		</div>
	</div><!-- /.footer-social-container -->


	<div class="container-fluid footer-brand-container">
	<div class="container">
	  <div class="row footer-menus-row">

	    <!-- logo -->
	    <div class="col-sm-6">
	      <a href="<?= esc_url(get_home_url()); ?>" class="footer-logo-a" title="Renegade Ada Cheng | Chicago-based Taiwanese Storyteller, Producer, Speaker | Home"></a>
	    </div>

	    <!-- copyright -->
	    <?php if(is_active_sidebar('Copyright')) { dynamic_sidebar('Copyright'); } ?>

	  </div>
	</div>


</footer>



<style>
	.footer-widgets-row > .col-footer + .col-footer { padding-top: 3rem; }
	.footer-nav + .footer-social-container { padding-top: 6.5rem; }
	.site-footer > .footer-social-container:first-child { padding-top: 3rem; }

	.footer-social-container { height: 32.386rem; padding-bottom: 3rem; }
	.footer-social-container .container { height: 26.086rem; }

	#nav_menu-3 { height: 6.016rem; }
	#mc4wp_form_widget-3 { height: 20.24rem; }

	.footer-brand-container .container { height: 10rem; }

	@media (min-width: 48rem) {
		.footer-social-container { height: auto; }
		.footer-social-container .container { height: auto; }
		#mc4wp_form_widget-3 { height: auto; }
		.footer-brand-container .container { height: auto; }
	}

	@media (min-width: 62rem) {
		.footer-widgets-row > .col-footer + .col-footer { padding-top: 0; }
	}
</style>




<?php wp_footer(); ?>



<!-- theme "later" styles -->
<?php global $style_vsn; ?>
<style>
<?php _e(file_get_contents(TDIR . '/css/later.css')); ?>
</style>



<!-- detect SVG support and update <body> attribute if needed - unminified version in THEME/js/dev/svg-support.js -->
<script>
document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image","1.1")||document.body.setAttribute("data-svg","no-inlinesvg");
</script>


<!-- trigger form successful submission as event in Google analytics -->
<?php if(is_archive() || is_single() || is_home()) : ?>
<script type='text/javascript'>
window.onload = (e) => {

  var $submit_success = $('#wpforms-confirmation-379');

  if ( $submit_success.length ){
      gtag('event', 'contact', { 'event_category' : 'Sidebar Contact Form', 'event_action' : 'Form Submitted', 'event_label' : 'from <?php _e(get_the_title()); ?>'})
  }
};
</script>
<?php elseif(is_page(array('contact', 'producing', 'speaking'))) : ?>
<script>
window.onload = (e) => {

  var $submit_success = $('#wpforms-confirmation-145');

  if ( $submit_success.length ){
      gtag('event', 'contact', { 'event_category' : 'Contact Form', 'event_action' : 'Form Submitted', 'event_label' : 'from <?php _e(get_the_title()); ?>' })
  }
};
</script>
<?php endif; ?>


</body>
</html>
