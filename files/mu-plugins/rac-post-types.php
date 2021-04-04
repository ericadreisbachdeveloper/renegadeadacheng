<?php

/*
Plugin Name: Renegade Ada Cheng post types
Version: 1.0
Description: Add custom post types and taxonomies as needed (Events)
Author: erica dreisbach
Author URI: https://ericadreisbach.com
*/

// Change "Posts" to "Videos"
add_action( 'init', 'rac_change_post_object' );

function rac_change_post_object() {
    $get_post_type = get_post_type_object('post');

    $labels = $get_post_type->labels;
    $labels->name = 'Video Posts';
    $labels->singular_name = 'Video Posts';
    $labels->add_new = 'Add New Video Post';
    $labels->add_new_item = 'Add New Video Post';
    $labels->edit_item = 'Edit Video Post';
    $labels->new_item = 'Video Posts';
    $labels->view_item = 'View Video Posts';
    $labels->search_items = 'Search Video Posts';
    $labels->not_found = 'No Video Posts found';
    $labels->not_found_in_trash = 'No Video Posts found in Trash';
    $labels->all_items = 'All Video Posts';
    $labels->menu_name = 'Video Posts';
    $labels->name_admin_bar = 'Video Posts';
}


add_action( 'admin_menu', 'change_menu_icon' );

function change_menu_icon() {

		// Access global variables.
		global $menu;

		foreach ( $menu as $key => $val ) {
			if ( __( 'Video Posts', 'plugin-name' ) == $val[0] ) {
				$menu[$key][6] = 'dashicons-video-alt3';
			}
		}
	}
