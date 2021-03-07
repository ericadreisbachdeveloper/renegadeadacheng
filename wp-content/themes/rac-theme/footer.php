<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
</div><!-- /.wrapper -->



<footer class="site-footer">


	<!-- if is a child page, show navigation-->
	<?php include(locate_template('template/pagination_from_menu.php')); ?>


	<div class="container-fluid -magenta-bg footer-social-container">
		<div class="container">
			<div class="row footer-widgets-row">
				<?php if(is_active_sidebar('Footer Widgets')) { dynamic_sidebar( 'Footer Widgets' ); } ?>
			</div>
		</div>
	</div>


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
	</div>


</footer>



<?php wp_footer(); ?>



</body>
</html>
