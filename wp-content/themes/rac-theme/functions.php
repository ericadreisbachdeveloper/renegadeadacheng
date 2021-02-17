<?php
// Author: erica dreisbach | @ericadreisbach



// 0. set up a constant to the template directory to avoid extra queries to DB
define('TDIR', get_bloginfo('template_directory'));


// 1. For debugging - output all scripts
/*
function inspect_scripts() {
    global $wp_scripts;
    foreach( $wp_scripts->queue as $handle ) :
        echo $handle . ' | ';
    endforeach;
}
*/
//add_action( 'wp_print_scripts', 'inspect_scripts', 99 );
