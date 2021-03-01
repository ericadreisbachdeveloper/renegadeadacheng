<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
</div><!-- /.wrapper -->



<footer class="site-footer container-fluid">
	<div class="container">
		<div class="row footer-menus-row">
			<div class="col-md-6">
				<a href="<?= esc_url(get_home_url()); ?>" class="footer-logo-a" title="Renegade Ada Cheng | Chicago-based Taiwanese Storyteller, Producer, Speaker | Home"></a>
			<?php //if(is_active_sidebar('Footer Menus')) { dynamic_sidebar( 'Footer Menus' ); } ?>
		</div>
	</div>


	<div class="row footer-copyright-row">
		<div class="container">
			<?php if(is_active_sidebar('Copyright')) { dynamic_sidebar('Copyright'); } ?>
		</div>
	</div>
</footer>



<?php wp_footer(); ?>



</body>
</html>
