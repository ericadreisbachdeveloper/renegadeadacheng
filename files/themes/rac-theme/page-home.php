<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>

<?php /* Template Name: Home*/ get_header(); ?>


<main data-role="main" id="main" class="default-page-main">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>


		<?php global $post; $post = get_post(); include(locate_template('template/hero.php')); ?>


		<?php include(locate_template('template/no_hero_title_home.php')); ?>


		<style>
		[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media,
		[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media [class*="wp-image"] {
			width: 17rem; height: calc(17rem * 646 / 545);
		}
		</style>


		<?php include(locate_template('template/page_content.php')); ?>


		<?php endwhile; ?>


		<?php else: ?>
		<h2><?php _e( 'Sorry, nothing to display.', 'dbllc' ); ?></h2>


	<?php endif; ?>

</main>



<?php get_footer(); ?>
