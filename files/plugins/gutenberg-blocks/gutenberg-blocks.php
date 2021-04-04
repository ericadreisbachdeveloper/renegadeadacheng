<?php

/*
Plugin Name: Gutenberg Blocks
Version: 1.1
Plugin URI: https://florianbrinkmann.com/en/5339/gutenberg-wrap-core-block-in-element/
Description: Wrap elements from Wordpress 5+ (Gutenberg) in wrapper divs
Author URI: https://gist.github.com/webmandesign/5b50d521e085198dce4eadb6864eb5a3
*/


if ( ! defined( 'ABSPATH' ) ) {  exit; }

function dbllc_gutenberg_wrapper( $block_content, $block ) {



	// non-empty blocks get the wrapper
	// core/column does not get wrapper
	// core/cover does not get wrapper
	// core/columns does not get wrapper
	// core/group does not get wrapper

	if( $block['blockName'] != '' && ($block['blockName'] !== "core/cover") && ($block['blockName'] !== "core/separator") && ($block['blockName'] !== "core/column") && ($block['blockName'] !== "core/group") )  {

		$block_content = '<div class="gutenberg-section ' . sanitize_title($block['blockName']) . '"><div class="gutenberg-container">' . $block_content . '</div></div>';

		return $block_content;
	}


	// core/cover (hero) gets special treatment
	elseif ($block['blockName'] == "core/cover") {
		$block_content = '<div class="gutenberg-section ' . sanitize_title($block['blockName']) . '"><div class="gutenberg-container">' . $block_content . '</div></div>';

		return $block_content;

	}


	else { return $block_content; }

}
add_filter( 'render_block', 'dbllc_gutenberg_wrapper', 10, 2 );
