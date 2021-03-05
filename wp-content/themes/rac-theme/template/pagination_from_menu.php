<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>

<?php

	$main = wp_get_nav_menu_object('main-menu');

	$menu_items = wp_get_nav_menu_items( $main->term_id, array( 'order' => 'DESC' ) );


	foreach ($menu_items as $menu_item) {
		$menu_items_ids[] = $menu_item->object_id;
		$menu_parent_ids[] = $menu_item->menu_item_parent;
		$menu_items_urls[] = $menu_item->url;
		$menu_items_titles[] = $menu_item->title;
	}


	// get current page id
	$current_post = get_post();
	$current_post_id = $current_post->ID;
	$current_title = $current_post->post_title;


	// get the array key for the current page
	// within the array menu_items
	$current_page_array_key = array_search($current_post_id, $menu_items_ids);



	// I. Current Page is a Child

	// get the current page parent menu id
 	$current_page_menu_object    = $menu_items[$current_page_array_key];
	$current_page_parent_menu_id = $current_page_menu_object->menu_item_parent;


	// get array keys of all menu objects where
	// menu_item_parent = $current_page_parent_menu_id
	$siblings = array_keys($menu_parent_ids, $current_page_parent_menu_id);


	// create arrays of sibling titles and urls
	foreach ($siblings as $sibling) {
		$sibling_titles[] = $menu_items_titles[$sibling];
		$sibling_urls[] = $menu_items_urls[$sibling];
	}


	// get key of current page with siblings array
	$current_sibling_key = array_keys($sibling_titles, $current_title);

	// get next sibling
	$next_sibling_key = $current_sibling_key[0] + 1;

	// if next sibling exists then print it
	if( array_key_exists($next_sibling_key, $sibling_titles) ) {
		$next_sibling_title = $sibling_titles[$next_sibling_key];
		$next_sibling_url = $sibling_urls[$next_sibling_key];
	}

	// otherwise print first in array
	else {
		$next_sibling_title = $sibling_titles[0];
		$next_sibling_url = $sibling_urls[0];
	}



	// II. Current Page is a Parent

	// get current page id
	$current_page_is_parent_menu_id = $current_page_menu_object->ID;

	// get first kid title
	$first_kid_title = $menu_items_titles[$current_page_array_key + 1];

	// get first kid url
	$first_kid_url = $menu_items_urls[$current_page_array_key + 1];


?>



<!-- if this page has a parent, then show next sibling here -->
<?php if($current_page_parent_menu_id != '0') : ?>
<div class="container-fluid -mauve-bg footer-nav">
	<div class="container" role="navigation">

		 <a class="pagination-a" href="<?php echo esc_url($next_sibling_url); ?>">NEXT: <?php _e($next_sibling_title); ?></a>
		 <div class="clear"> </div>

	 </div>
</div>


<!-- if this page IS a parent, then show first sibling here -->
<?php elseif($current_page_parent_menu_id = '0') : ?>

<div class="container-fluid -mauve-bg footer-nav">
	<div class="container" role="navigation">

		 <a class="pagination-a" href="<?php echo esc_url($first_kid_url); ?>">NEXT: <?php _e($first_kid_title); ?></a>
		 <div class="clear"> </div>

	 </div>
</div>

<?php endif; ?>
