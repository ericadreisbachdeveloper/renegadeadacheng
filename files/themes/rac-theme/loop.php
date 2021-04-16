<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>


<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
<?php $k = 0; if (have_posts()): while (have_posts()) : the_post(); ?>
<article <?php if($k == 0 && 1 == $paged) { _e('data-first '); } ?>id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<!-- if it's the most recent postshow the whole post  -->
	<?php if($k == 0 && 1 == $paged) : ?>

	<h2>The Latest: <?php the_title(); ?></h2>
	<h3 class="-latest-h3"><?php the_time('F j, Y'); ?></h3>

	<?php the_content(); ?>



	<!-- otherwise, just show the thumb + excerpt -->
	<?php else : ?>

	<?php if(has_post_thumbnail()) : ?>
	<a class="-no-line" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
	<?php endif; ?>

	<div class="text">
		<h2 class="looks-like-h1"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<h3 class="looks-like-h2"><?php the_time('F j, Y'); ?></h3>
		<?php  $excerpt = dbllc_excerpt(); _e($excerpt); ?>
	</div>
	<?php endif; ?>



</article>
<?php $k++; endwhile;  ?>



<?php else: ?>
<article>
	<h2><?php _e( 'Sorry, nothing to display.', 'dbllc' ); ?></h2>
</article>
<?php endif; ?>
