<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
</div><!-- /.wrapper -->



<footer class="site-footer container-fluid">
	<div class="row footer-menus-row">
		<div class="container">
			<div class="row">
				<?php if(is_active_sidebar('Footer Menus')) { dynamic_sidebar( 'Footer Menus' ); } ?>
			</div>
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
