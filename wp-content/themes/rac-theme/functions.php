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


// 2. Conditionally remove unnecessary scripts
function deregister_javascript() {
		   wp_dequeue_script( 'conditionizr' );
		wp_deregister_script( 'conditionizr' );

       wp_dequeue_script( 'modernizr' );
    wp_deregister_script( 'modernizr' );

       wp_dequeue_script( 'html5blankscripts' );
    wp_deregister_script( 'html5blankscripts' );

   		 wp_dequeue_script( 'jquery' );
	  wp_deregister_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'deregister_javascript', 100 );


// 2b. Remove jQuery migrate
function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];

        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');



// 3. For debugging - output all styles
/*
function inspect_styles() {
    global $wp_styles;
    foreach( $wp_styles->queue as $handle ) :
        echo $handle . ' | ';
    endforeach;
}
add_action( 'wp_print_scripts', 'inspect_styles', 99 );
*/



// 4. Conditionally remove unnecessary styles
function deregister_css() {
 	   wp_dequeue_style( 'bodhi-svgs-attachment' );
  wp_deregister_style( 'bodhi-svgs-attachment' );

     wp_dequeue_style( 'wp-block-library' );
  wp_deregister_style( 'wp-block-library' );

     wp_dequeue_style( 'normalize' );
  wp_deregister_style( 'normalize' );

     wp_dequeue_style( 'html5blank' );
  wp_deregister_style( 'html5blank' );
}
add_action('wp_enqueue_scripts', 'deregister_css', 100 );



// 5. Style vsn
global $style_vsn;
$style_vsn = '1.1.03';



// 6a. Header scripts (header.php)
function dbllc_header_scripts() {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

      wp_register_script('strict', get_stylesheet_directory_uri() . '/js/strict.js', array('cloudjquery'), '1.0.0');
      wp_enqueue_script('strict'); // Enqueue it!
  }
}
add_action('wp_head', 'dbllc_header_scripts');



// 7. Load jQuery from Google API
function usecloudjquery() {
 if(!is_admin()) {
	 wp_register_script('cloudjquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), '3.3.1', false);
   wp_enqueue_script('cloudjquery');
 }
}
add_action('init', 'usecloudjquery');



// 8. Remove emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');



// 9. Remove comment-reply.min.js from footer
function deregister_header(){
 wp_deregister_script( 'comment-reply' );
}
add_action('init','deregister_header');



// 10. Remove embed
function deregister_footer(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'deregister_footer' );



// 11. Add footer scripts
function footer_scripts() {
  wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', 'jquery', '4.1.1');
  wp_enqueue_script('bootstrap');
}
add_action('wp_footer', 'footer_scripts');



// 12. Automatically update plugins
add_filter( 'auto_update_plugin', '__return_true' );



// 13. Remove type="text/javascript" and type="text/css"
add_filter('style_loader_tag', 'remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'remove_type_attr', 10, 2);

function remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}



// 14. Disable xml-rpc as this is commonly exploited to attack other sides
add_filter( 'xmlrpc_enabled', '__return_false' );


// 15. LOGIN


// 15a. Remove login message that confirms username in functions.php
//     src: https://ehikioya.com/forums/topic/how-to-change-or-remove-the-wordpress-login-error-message/
function remove_error_msg( $error ) {
    return '';
}
add_filter( 'login_errors', 'remove_error_msg' );


// 15b. Add reCAPTCHA to login
function load_custom_scripts() {

		if ( is_page_template ( 'page-login.php' ) ) {
			wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js', 'jquery', '2.0.0', 'all');
			wp_enqueue_script('recaptcha');

			wp_register_script('recaptcha-sitekey', get_stylesheet_directory_uri() . '/js/recaptcha-sitekey.js', 'jquery', '1.0.1', 'all');
			wp_enqueue_script('recaptcha-sitekey');
		}
}

if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'load_custom_scripts', 99);
}
