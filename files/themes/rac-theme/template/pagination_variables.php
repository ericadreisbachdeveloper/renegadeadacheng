<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>


<?php

  global $main, $menu_items, $current_post, $current_post_id, $menu_items_ids, $current_page_array_key, $current_page_menu_object, $current_page_parent_menu_id, $data_footer, $menu_items_titles, $menu_items_ids, $menu_items_urls, $menu_items_menu_ids;


  $main = wp_get_nav_menu_object('main-menu');

  $menu_items = wp_get_nav_menu_items( $main->term_id, array( 'order' => 'DESC' ) );

  $current_post = get_post();

  if(isset($current_post)) {
    $current_post_id = $current_post->ID;
  }

  foreach ($menu_items as $menu_item) {
    $menu_items_ids[] = $menu_item->object_id;
    $menu_items_menu_ids[] = $menu_item->ID;
    $menu_parent_ids[] = $menu_item->menu_item_parent;
    $menu_items_urls[] = $menu_item->url;
    $menu_items_titles[] = $menu_item->title;
  }


  $current_page_array_key = array_search($current_post_id, $menu_items_ids);

  $current_page_menu_object    = $menu_items[$current_page_array_key];
  $current_page_parent_menu_id = $current_page_menu_object->menu_item_parent;


  // has parent OR is WORKHOPS landing or STORYTELLING landing
  if( ($current_page_parent_menu_id !== '0')  ||  ($current_post_id == '27') || ($current_post_id == '35') )
  { $data_footer = "has-pagination"; }

  // if single, might have verbose pagination - no set height
  elseif(is_single()) { $data_footer = "no-sticky"; }

  // everyone else
  else { $data_footer = "no-pagination"; }

?>
