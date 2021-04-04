<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
<?php get_header(); ?>



<main data-role="main">
	<div class="container">
		<div class="row">


			<div class="col-content col-lg-8">
				<section class="section">


					<?php if (have_posts()): while (have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


						<h1 class="single-h1"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>


						<div class="meta-div">
						  <span class="meta-time"><?php the_time('F j, Y'); ?></span>
							&nbsp; &nbsp;
						  <span class="meta-categories"><?php the_category(' ') ?></span>
						</div>


						<?php the_content(); ?>


						<div class="sr-only tags<?php if(get_the_tags() == '') : ?> -empty<?php endif; ?>"><?php the_tags('<i class="fa fa-tag"></i>&nbsp;', ' ', ''); ?></div>


					</article>
					<?php endwhile; ?>


					<?php else: ?>
					<article>
						<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>
					</article>
					<?php endif; ?>


				</section>

			</div><!-- /.col-content -->



			<div class="col-lg-4 col-sidebar">
				<?php if(is_active_sidebar('sidebar')) { dynamic_sidebar( 'sidebar' ); } ?>
			</div><!-- /.col-sidebar -->



		</div><!-- /.row -->

	</div><!-- /.container -->


	<?php if(is_user_logged_in()) : ?>
		<?php edit_post_link(); ?>
	<?php endif; ?>


</main>



<?php get_footer(); ?>
