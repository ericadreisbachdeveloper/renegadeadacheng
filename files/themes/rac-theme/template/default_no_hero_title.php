<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>


<!-- If the first block is a cover            -->
<!-- then within the page body                -->
<!-- output all blocks except the first block -->


<?php	global $post; global $blocks; $blocks = parse_blocks( $post->post_content ); ?>


  <div class="gutenberg-section -no-hero">
    <div class="gutenberg-container container">
      <h1 class="sr-only"><?php the_title(); ?></h1>
    </div>
  </div>
