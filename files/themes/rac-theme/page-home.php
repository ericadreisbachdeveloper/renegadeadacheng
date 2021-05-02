<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>

<?php /* Template Name: Home*/ get_header(); ?>


<main data-role="main" id="main" class="default-page-main">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>


		<?php global $post; $post = get_post(); include(locate_template('template/hero.php')); ?>


		<?php include(locate_template('template/no_hero_title_home.php')); ?>


		<style>

		.-animate-text [data-aos] { position: relative; height: 3rem; }

		[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media,
		[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media [class*="wp-image"] {
			width: 17rem; height: calc(17rem * 646 / 545);
		}

		[data-role="main"] > div:nth-of-type(2) .wp-block-buttons[class*="is-content-justification"] {
			-webkit-flex-direction: column;
		  -moz-flex-direction: column;
		  -ms-flex-direction: column;
			flex-direction: column;

			-webkit-align-items: center;
			-moz-align-items: center;
			-ms-align-items: center;
			align-items: center;
		}

		[data-role="main"] .-magenta-bg [href].wp-block-button__link {
			font-size: 1rem;
    	line-height: 1.666;
			padding: .8rem .9rem .7rem 1.3rem;
		}

		.wp-block-buttons[class*="is-content-justification"] .core-button { padding-bottom: 2rem; }

		/* [data-role="main"] > div:nth-of-type(2).wp-block-group { height: 17.959rem; } */


		@media (min-width: 37.55rem) {

			[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media,
			[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media [class*="wp-image"] {
				width: 20rem; height: calc(20rem * 646 / 545);
			}

			.-animate-text [data-aos] { height: auto; }
			.-animate-text br { display: block; }

			.page-template-page-home [data-role="main"]>.gutenberg-section:first-of-type .wp-block-media-text .wp-block-media-text__media { margin-right: -3rem; }

		}



		@media (min-width: 48rem) {

			[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media,
			[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media [class*="wp-image"] {
				width: 22.5rem; height: calc(22.5rem * 646 / 545);
			}


			/* [data-role="main"] > div:nth-of-type(2).wp-block-group { height: auto; } */

			[data-role="main"] > div:nth-of-type(2) .wp-block-buttons[class*="is-content-justification"] {
				-webkit-flex-direction: row;
			  -moz-flex-direction: row;
			  -ms-flex-direction: row;
				flex-direction: row;

				-webkit-align-items: center;
				-moz-align-items: center;
				-ms-align-items: center;
				align-items: center;
			}

			.page-template-page-home [data-role="main"]>.gutenberg-section:first-of-type .wp-block-media-text .wp-block-media-text__media { margin-right: 3rem; }
		}



		@media (min-width: 75rem) {
			[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media,
			[data-role="main"] > .gutenberg-section:first-of-type .wp-block-media-text__media [class*="wp-image"] {
				width: 26rem; height: calc(26rem * 646 / 545);
			}
		}

		</style>


		<?php include(locate_template('template/page_content.php')); ?>


		<?php endwhile; ?>


		<?php else: ?>
		<h2><?php _e( 'Sorry, nothing to display.', 'dbllc' ); ?></h2>


	<?php endif; ?>

</main>



<?php get_footer(); ?>
