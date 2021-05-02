<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
</div><!-- /.wrapper -->



<footer class="site-footer">


	<!-- if is single, show navigation -->
	<?php if(is_single()) { include(locate_template('template/pagination_single.php')); } ?>


	<!-- show page-to-page navigation -->
	<?php if(!is_front_page()) { include(locate_template('template/pagination_from_menu.php')); }  ?>



	<div class="container-fluid footer-social-container">
		<style>
			.footer-social-container .container { height: 26.086rem; }
			#nav_menu-3 { height: 6.016rem; }
			#mc4wp_form_widget-3 { height: 20.24rem; }
			@media (min-width: 62rem) { .footer-social-container .container { height: auto; } #mc4wp_form_widget-3 { height: auto; } }
		</style>
		<div class="container">
			<div class="row footer-widgets-row">
				<?php if(is_active_sidebar('Footer Widgets')) { dynamic_sidebar( 'Footer Widgets' ); } ?>
			</div>
		</div>
	</div>


	<div class="container-fluid footer-brand-container">
		<style>
			.footer-brand-container .container { height: 8.749rem; }
			@media (min-width: 62rem) { .footer-brand-container .container { height: auto; } }
		</style>
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
	</div>


</footer>



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



</body>
</html>
