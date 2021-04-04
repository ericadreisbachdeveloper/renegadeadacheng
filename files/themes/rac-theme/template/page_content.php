<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>


<!-- If the first block is a cover            -->
<!-- then within the page body                -->
<!-- output all blocks except the first block -->


<?php

  global $blocks;

  if($blocks) {
    foreach($blocks as $block) {

      echo _e(apply_filters( 'the_content', render_block( $block ) ) );
    }
  }
?>




<?php if(is_user_logged_in()) : ?>
  <div class="clear"> </div>
  <?php edit_post_link(); ?>
  <div class="clear"> </div>
<?php endif; ?>
