<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
<?php get_header(); ?>



<main data-role="main" class="-archive">
	<div class="container">


		<div class="row">


			<div class="col-content col-lg-8">

				<h1><?php single_cat_title(); ?> </h1>

				<?php get_template_part('loop'); ?>

				<?php get_template_part('pagination'); ?>

			</div><!-- /.col-content -->


			<div class="col-sidebar col-lg-4">
				<?php if(is_active_sidebar('sidebar')) { dynamic_sidebar( 'sidebar' ); } ?>

			</div><!-- /.col-sidebar -->


		</div>
	</div>
</main>




<?php get_footer(); ?>
