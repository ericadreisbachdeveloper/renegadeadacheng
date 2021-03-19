<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>



<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<a class="-no-line" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>

	<div class="text">
		<h2 class="looks-like-h1"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<h3 class="looks-like-h2"><?php the_time('F j, Y'); ?></h3>
		<?php the_excerpt(); ?>
	</div>


</article>
<?php endwhile; ?>



<?php else: ?>
<article>
	<h2><?php _e( 'Sorry, nothing to display.', 'dbllc' ); ?></h2>
</article>
<?php endif; ?>
