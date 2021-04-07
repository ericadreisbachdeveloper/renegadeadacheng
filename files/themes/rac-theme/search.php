<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
<?php get_header(); ?>



<main data-role="main" id="main">
	<?php $s = sprintf( __('%s', 'dbllc'), $wp_query->found_posts);
	if($s == '1') { $sp = ''; } else { $sp = 's'; } ?>



		<div class="container">

			<h1><?php echo sprintf( __( '%s Search Result' . $sp . ' for &ldquo;', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); echo '&rdquo;'; ?></h1>


			<div class="-corseted -left">
				<section class="section">




			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



				<?php if ( has_post_thumbnail()) : ?>

					<?php $img_id = get_post_thumbnail_id(); $img_array = wp_get_attachment_image_src($img_id, "medium"); $img = $img_array[0]; ?>

				<?php endif; ?>


				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>


				<?php //echo _e(get_template_part('meta')); ?>


				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail', ['class' => 'alignleft']); ?></a>


				<!-- if there's a meta, post meta -->
				<?php if(class_exists('acf') && get_field('meta-description')) : ?>
					<?php the_field('meta-description'); ?>&nbsp;<a href="<?php the_permalink(); ?>">Read&nbsp;More</a>

				<!-- otherwise, Wordpress-generated excerpt -->
				<?php else : ?>

					<?php _e(dbllc_excerpt()); ?>&nbsp;<a href="<?php the_permalink(); ?>">Read&nbsp;More</a>

				<?php endif; ?>



			</article>
			<?php endwhile; ?>



			<?php else: ?>
			<article class="hentry">
				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
			</article>
			<?php endif; ?>


			<?php get_template_part('pagination'); ?>

			</section>

		</div>
	</div>
</main>



<?php get_footer(); ?>
