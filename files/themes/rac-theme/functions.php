<?php
// Author: erica dreisbach | @ericadreisbach



// 0. set up a constant to the template directory to avoid extra queries to DB
define('TDIR', get_bloginfo('stylesheet_directory'));


// 1. For debugging - output all scripts
/*
function inspect_scripts() {
    global $wp_scripts;
    foreach( $wp_scripts->queue as $handle ) :
        echo $handle . ' | ';
    endforeach;
}

add_action( 'wp_print_scripts', 'inspect_scripts', 99 );
*/


// 2. Conditionally remove unnecessary scripts
function deregister_javascript() {
		   wp_dequeue_script( 'conditionizr' );
		wp_deregister_script( 'conditionizr' );

       wp_dequeue_script( 'modernizr' );
    wp_deregister_script( 'modernizr' );

       wp_dequeue_script( 'html5blankscripts' );
    wp_deregister_script( 'html5blankscripts' );

   		 wp_dequeue_script( 'jquery' );
		   // for reasons unknown, deREGISTER of default jquery breaks WPForms
		   // even if jquery is deQUEUED
	     // wp_deregister_script( 'jquery' );


       // add minified lazysizes in header with defer
		   wp_dequeue_script( 'lazysizes' );
	  wp_deregister_script( 'lazysizes' );

		// if is not page Events, deregister Event scripts
		if(!is_page('Events')) {
       wp_dequeue_script( 'simcal-qtip' );
    wp_deregister_script( 'simcal-qtip' );

       wp_dequeue_script( 'simcal-fullcal-moment' );
    wp_deregister_script( 'simcal-fullcal-moment' );

       wp_dequeue_script( 'simcal-moment-timezone' );
    wp_deregister_script( 'simcal-moment-timezone' );

       wp_dequeue_script( 'simcal-default-calendar' );
    wp_deregister_script( 'simcal-default-calendar' );

       wp_dequeue_script( 'simplecalendar-imagesloaded ' );
    wp_deregister_script( 'simplecalendar-imagesloaded ' );
	}
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


// 2c. jQuery conditional to Contact
/*
function contact_jquery() {
	if ( is_page ( 'Contact' ) ) {
		wp_enqueue_script( 'jquery' );
	}
}
*/
//add_action('wp_enqueue_scripts', 'contact_jquery', 10, 0);



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
$style_vsn = '1.2.68';



// 6. Header scripts (header.php)
function dbllc_header_scripts() {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

			wp_register_script('cloudjquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', false);
			wp_enqueue_script('cloudjquery');

			wp_register_script('lazysizes-min', TDIR . '/js/lazysizes.5.2.2.min.js', array(), '5.2.2', false);
			wp_enqueue_script('lazysizes-min');

			wp_register_script('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js');
			//wp_register_script('aos', TDIR . '/js/aos.min.js', array(), '2.3.1');
			//wp_register_script('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js');
			wp_enqueue_script('aos');

			wp_register_script('strict', TDIR . '/js/strict.min.js', array('cloudjquery'), '1.0.3');
			wp_enqueue_script('strict');
  }
}
add_action('wp_enqueue_scripts', 'dbllc_header_scripts', 10, 0);




// 7. Add defer to scripts
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

function add_async_attribute($tag, $handle) {

	if ( ! is_admin() ) {
		if ( 'cloudjquery' !== $handle ) {
			return str_replace( ' src', ' defer src', $tag );
		}
		elseif( 'cloudjquery' == $handle ) {
			return str_replace( ' src', 'defer crossorigin="anonymous" src', $tag );
		}
	}
	return $tag;
}



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
	wp_register_script('aosinit', TDIR . '/js/aos-init.js', array('aos'));
	wp_enqueue_script('aosinit');
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
			wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js', 'jquery', '3.0.0', 'all');
			wp_enqueue_script('recaptcha');
		}

		// attach Google sitekey to login form submit
		if( is_page_template( 'page-login.php' )) {
			wp_register_script('recaptcha-sitekey', get_stylesheet_directory_uri() . '/js/recaptcha-sitekey.js', 'jquery', '3.0.0', 'all');
			wp_enqueue_script('recaptcha-sitekey');
		}

		// for WP Forms, enter reCAPTCHA keys directly on WPForms > Settings > CAPTCHA
		// https://ericadreisbach.com/adacheng/wp-admin/admin.php?page=wpforms-settings&view=captcha
}

if(!is_admin()) { add_action('wp_enqueue_scripts', 'load_custom_scripts', 99); }


// 15c. Remove login message that confirms username in functions.php
//add_filter('login_errors',create_function('$a', "return null;"));


// 15d. Hide default login screen
function dbllc_login_redirect(){
	wp_redirect( home_url() );
	exit();
}
add_action( 'login_head', 'dbllc_login_redirect');


// 15e. Redirect home on logout
add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
	wp_redirect( home_url() );
	exit();
}


// 15f. Redirect to login page on failed login
add_action( 'wp_login_failed', 'darkblack_login_fail' );
function darkblack_login_fail( $username ) {
     $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?

     // if there's a valid referrer, and it's not the default log-in screen
	 if ( !empty($referrer) && !strstr($referrer,'wp-login') /*&& !strstr($referrer,'wp-admin')*/ ) {
			 	  // change admin-login to correct page as needed
					// append (login=failed) to the URL
          wp_redirect(home_url() . "/admin-login/" );
          exit;
     }
}


// 15g. Redirect to login page with blank username or password
add_filter( 'authenticate', 'darkblank_blank_username_password', 1, 3);

function darkblank_blank_username_password( $user, $username, $password ) {
	global $page_id;
	$login_page = home_url();
	$referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?

	// if there's a valid referrer, and it's not the default log-in screen
	if ( !empty($referrer) && !strstr($referrer,'wp-login') /* && !strstr($referrer,'wp-admin') */ ) {
		if( $username == "" || $password == "" ) {
			wp_redirect( $login_page . "/admin-login/" );
			exit;
		}
	}
}


// 15h. Disable the modal login screen on timeout
remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );


// 15i. CUSTOMIZE WP-LOGIN - relevant to a different implementation
// Custom login screen for wp-login.php
/*
function my_login_logo() { ?>
    <style type="text/css">
    #login h1 a, .login h1 a { background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo.svg); height:65px; width:320px; background-size: contain; background-repeat: no-repeat; margin-bottom: 2em; }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'SITE TITLE';
}
*/
//add_filter( 'login_headertitle', 'my_login_logo_url_title' );


// 15j. Exclude login page template from native search results
//      also exclude Kitchen Sink
//      src: https://stackoverflow.com/a/28983318
function exclude_page_templates_from_search($query) {

    global $wp_the_query;

		$excluded = array(
				'key' => '_wp_page_template',
				'value' => array('page-kitchensink.php', 'page-login.php'),
				'compare' => 'NOT IN',
		);

		$no_template = array(
			'key' => '_wp_page_template',
			'compare' => 'NOT EXISTS',
		);


    if ( ($wp_the_query === $query) && (is_search()) && ( ! is_admin()) ) {

        $meta_query =
            array(

                // set OR
                'relation' => 'OR',

                // remove pages with excluded templates from results
                $excluded,

                // show entries without a '_wp_page_template' key (posts)
                $no_template,
            );

        $query->set('meta_query', $meta_query);
    }
}
add_filter('pre_get_posts','exclude_page_templates_from_search');








// 16. Documentation
add_action('admin_menu', 'doc_menu');

function doc_fxn() {
	include('documentation.php');
}

function doc_menu() {
	add_menu_page( 'Documentation', 'Documentation', 'manage_options', 'documentation', 'doc_fxn', 'dashicons-book-alt', 3 );
}



// 17a. Output theme image sizes
//   useful when working with parents / children

/*
function wp_get_additional_image_sizes() {
    global $_wp_additional_image_sizes;

    if ( ! $_wp_additional_image_sizes ) {
        $_wp_additional_image_sizes = array();
    }

    return $_wp_additional_image_sizes;
}
*/


// 17b. Thumbnails
if (function_exists('add_theme_support')) {
    add_theme_support('menus');               // Menu Support

    add_theme_support('post-thumbnails');
    add_image_size('hero', 1533, 570, true);  // Hero
    add_image_size('large', 700, '', true);   // Large Thumbnail
    add_image_size('medium', 250, '', true);  // Medium Thumbnail
    add_image_size('small', 120, '', true);   // Small Thumbnail
		add_image_size('square', 400, 400, true); // Square Thumbnail

    add_theme_support('automatic-feed-links');
    load_theme_textdomain('dbllc', get_template_directory() . '/languages');
}


// 17c. Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
/* function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}*/



// 18. Inline scripts in footer
//  a. Accessible nav - subnavs appear on hover - unminifed in js/dev/accessible-nav.js
//  b. Spamspan - protect email addresses from scrapers and spammers
function inline_scripts(){

	_e('<script>window.addEventListener("load",e=>{jQuery.fn.accessibleDropDown=function(){var e=jQuery(this);jQuery("li",e).mouseover(function(){jQuery(this).addClass("hover")}).mouseout(function(){jQuery(this).removeClass("hover")}),jQuery("a",e).focus(function(){jQuery(this).parents("li").addClass("show")}).blur(function(){jQuery(this).parents("li").removeClass("show")})},jQuery(".nav").accessibleDropDown()});</script>');

	_e('<script>var spamSpanMainClass="spamspan",spamSpanUserClass="u",spamSpanDomainClass="d",spamSpanAnchorTextClass="t",spamSpanParams=new Array("subject","body");function spamSpan(){for(var a=getElementsByClass(spamSpanMainClass,document,"span"),e=0;e<a.length;e++){for(var n=getSpanValue(spamSpanUserClass,a[e]),s=getSpanValue(spamSpanDomainClass,a[e]),t=getSpanValue(spamSpanAnchorTextClass,a[e]),p=new Array,r=0;r<spamSpanParams.length;r++){var	 l=getSpanValue(spamSpanParams[r],a[e]);l&&p.push(spamSpanParams[r]+"="+encodeURIComponent(l))}var m=String.fromCharCode(64),o=cleanSpan(n)+m+cleanSpan(s),d=document.createTextNode(t||o),c=String.fromCharCode(109,97,105,108,116,111,58)+o;c+=p.length?"?"+p.join("&"):"";var u=document.createElement("a");u.className=spamSpanMainClass,u.setAttribute("href",c),u.appendChild(d),a[e].parentNode.replaceChild(u,a[e])}}function getElementsByClass(a,e,n){var s=new Array;null==e&&(node=document),null==n&&(n="*");for(var t=e.getElementsByTagName(n),p=t.length,r=new RegExp("(^|s)"+a+"(s|$)"),l=0,m=0;l<p;l++)r.test(t[l].className)&&(s[m]=t[l],m++);return s}function getSpanValue(a,e){var n=getElementsByClass(a,e,"span");return!!n[0]&&n[0].firstChild.nodeValue}function cleanSpan(a){return a=(a=a.replace(/[\[\(\{]?[dD][oO0][tT][\}\)\]]?/g,".")).replace(/\s+/g,"")}function addEvent(a,e,n){a.addEventListener?a.addEventListener(e,n,!1):a.attachEvent&&(a["e"+e+n]=n,a[e+n]=function(){a["e"+e+n](window.event)},a.attachEvent("on"+e,a[e+n]))}addEvent(window,"load",spamSpan);</script>');

}
add_action( 'wp_footer', 'inline_scripts' );



// 19. Shortcode to output current year
//     enter [year]
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');



// 20. Customizer
function remove_styles_sections($wp_customize) {
    // a. remove site icon and control via favicon.php instead
    $wp_customize->remove_control('site_icon');

    // b. remove custom CSS and its associated performance drag
    $wp_customize->remove_control('custom_css');
}
add_action( 'customize_register', 'remove_styles_sections', 20, 1 );



// 21. Options page for global elements powered by ACF
//     a. meta-description   (text area ~ 300 chars)
//     b. social-img         (img ~  1200px wide x 630px high)
//     c. social-txt         (text area ~ 300 chars)
if( function_exists('acf_add_options_page') ) {

 acf_add_options_page();

 /*acf_add_options_sub_page(array(
   'page_title' 	=> 'Meta / SEO',
   'menu_title' 	=> 'Meta / SEO'
 )); */
}

if (function_exists('acf_set_options_page_menu')){
	acf_set_options_page_menu('Open Graph');
}



// 22. MENUS
// 22a. Register menu locations
function register_menu() {
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'dbllc'),
				//'footer-menu-1' => __('Footer 1', 'dbllc'),
				//'footer-menu-2' => __('Footer 2', 'dbllc'),
				//'footer-menu-3' => __('Footer 3', 'dbllc'),
				'social-menu' => __('Social Media Menu', 'dbllc')
    ));
}
add_action( 'init', 'register_menu' );


// 22a. Deregister parent theme menu locations
function wpse_remove_parent_theme_locations()
{
    unregister_nav_menu( 'header-menu' );
		unregister_nav_menu( 'sidebar-menu' );
		unregister_nav_menu( 'extra-menu' );
}
add_action( 'init', 'wpse_remove_parent_theme_locations', 20 );



// 22b. Add more menus to array as necessary
function dbllc_nav() {
	wp_nav_menu(
	array(
		'theme_location'  => 'main-menu',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'menu_class'      => 'menu',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
    'items_wrap'      => '<ul class="nav navbar-nav">%3$s</ul>',
		'depth'           => 0,   /* 0 means all levels of hierarchy */
		'after'						=> '<span class="open-submenu-a"></span>',
	));
}



// 23. Hide editor on specific pages
add_action( 'admin_init', 'hide_editor' );
function hide_editor() {

	$screen = get_current_screen();

	if ( is_object($screen) && $screen->parent_base == 'edit' ) {

		// get id
		global $post;
		$post_id = $post->ID;


	  // for specific page ids
		/*
	  if($post_id == '###' ) {
	    remove_post_type_support('page', 'editor');
	  }
	  */


		// for specific custom post types
		//remove_post_type_support( 'resource', 'editor' );


		// for specific templates
	  $template_file = get_post_meta($post_id, '_wp_page_template', true);

	  if($template_file == 'page-login.php'){
	    remove_post_type_support('page', 'editor');
	  }
	}
}



// 24. Sidebars / Widgets
if (function_exists('register_sidebar')) {

    // Define Widget areas

    register_sidebar(array(
        'name' => __('Footer Widgets', 'dbllc'),
        'description' => __('Add footer content blocks here', 'dbllc'),
        'id' => 'footer-widgets',
        'before_widget' => '<div id="%1$s" class="col-footer">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="footer-h2">',
        'after_title' => '</h2>'
    ));

		register_sidebar(array(
				'name' => __('Copyright', 'dbllc'),
				'description' => __('Add copyright and other small-text footer information here. Add current year and copyright symbol with shortcode [copyright-year]', 'dbllc'),
				'id' => 'copyright',
				'before_widget' => '<div id="%1$s" class="col-sm-6">',
				'after_widget' => '</div>',
				'before_title' => '<h2 class="sr-only">',
				'after_title' => '</h2>'
		));


		register_sidebar(array(
				'name' => __('Post Sidebar', 'dbllc'),
				'description' => __('Add widgets to appear in the sidebar of storytelling posts.', 'dbllc'),
				'id' => 'sidebar',
				'before_widget' => '<div id="%1$s">',
				'after_widget' => '</div>',
				'before_title' => '<h2 class="-title">',
				'after_title' => '</h2>'
		));
}



// 25. Pagination for paged posts
function dbllc_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}



// 26. Custom Posts per Page for Custom Post Type
// 26a. This function:
function custom_posts_per_page( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'CUSTOM' ) ) {
    $query->set( 'posts_per_page', '12' );
  }
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );


// 26b.   stucture wp_query like so
/*
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
	'orderby'   => 'date',
	'order' => 'DESC',
	'post_type' => 'CUSTOM',
	'paged' => $paged,
	'posts_per_page' => 12,
);

$wp_query = new WP_Query( $args ); ?>

<?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
*/



// 27a. Remove <p> tags from Excerpt altogether
remove_filter('the_excerpt', 'wpautop');


// 27b. Custom excerpts
function dbllc_excerpt() {
	global $post, $output;

	if(get_the_excerpt() != '') { $output = get_the_excerpt(); }
	else { $output =  get_the_content($post->ID); }

	// turn closing tags into spaces
	$output = str_replace("</h1>", "&nbsp;|&nbsp;", $output);
	$output = str_replace("</h2>", "&nbsp;", $output);
	$output = str_replace("</h3>", "&nbsp;", $output);
	$output = str_replace("</p>", "&nbsp;", $output);


	// strip out HTML tags and yield text
	// less robust
	$output = wp_strip_all_tags( $output );

	// slower
	// $output = wp_filter_nohtml_kses($output);
	// src: https://wordpress.stackexchange.com/a/163597


	// https://developer.wordpress.org/reference/functions/wptexturize/
	// turns " and ' into curly versions
	$output = apply_filters('wptexturize', $output);

	// https://developer.wordpress.org/reference/functions/convert_chars/
	// turns ampersands into &amp;
	$output = apply_filters('convert_chars', $output);

	// get the first 25 words
	$output = implode(' ', array_slice(explode(' ', $output), 0, 25));


	// add a space
	$output = $output . ' ';

	// if it's a post, add Watch Video
	if($post->type == "post") {
		$output = $output . '&nbsp;<a class=&quot;watch-video&quot; href=&quot;' . get_permalink($post->ID) . '&quot;>Watch&nbsp;Video</a>';
	}

	return $output;
}



// 28. Current Year
// [copyright-year]
add_shortcode('copyright-year', function($atts, $content) {
    extract(shortcode_atts(array(
        'sign' => 'true',
        s
    ), $atts));

    $current_year = date('Y');
    $print_sign = ($sign === 'true') ? '&copy;' : '';

    if($start === $current_year || $start === '')
        return "{$print_sign} {$current_year}";
    else
        //return "<span class='nowrap'>{$print_sign} {$start}-{$current_year}</span>";
				return "<span class='nowrap'>{$print_sign}&nbsp;{$current_year}</span>";
});



// 29. Duplicate pages
// Dupes appear as drafts. User is redirected to the edit screen
// src: https://www.hostinger.com/tutorials/how-to-duplicate-wordpress-page-post

// 29a. function
function rd_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	// nonce verification
	if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
		return;

	//get the original post id
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );

	//and all the original post data
	$post = get_post( $post_id );

	// if you don't want current user to be the new post author,
	// then change next couple of lines to this: $new_post_author = $post->post_author;
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	// if post data exists, create the post duplicate
	if (isset( $post ) && $post != null) {

		//new post data array
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		// insert the post by wp_insert_post() function
		$new_post_id = wp_insert_post( $args );

		// get all current post terms ad set them to the new post draft
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}

		// duplicate all post meta just in two SQL queries
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}


		// finally, redirect to the edit post screen for the new draft
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );


// 29b. Add the duplicate link to action list for post_row_actions
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}
	return $actions;
}

add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );



// 30. Remove HTML5 Blank defaults

// 30a. Remove HTML5 Blank Custom Post type
add_action( 'after_setup_theme', 'remove_html5blank_cpt' );
function remove_html5blank_cpt() {
    remove_action('init', 'create_post_type_html5');
}


// 30b. Remove page templates
//     src: https://wordpress.stackexchange.com/a/141654
function dbllc_remove_page_templates( $templates ) {
    unset( $templates['template-demo.php'] );
    return $templates;
}
add_filter( 'theme_page_templates', 'dbllc_remove_page_templates' );


// 30c. Remove Widget areas
//     src: https://wordpress.stackexchange.com/a/141654
function dbllc_remove_widgets(){
	unregister_sidebar( 'widget-area-1' );
	unregister_sidebar( 'widget-area-2' );
}
add_action( 'widgets_init', 'dbllc_remove_widgets', 11 );



// xx 31. Default timezone: Chicago
// date_default_timezone_set('America/Chicago');



// 32. Customizer
function dbllc_customize_register( $wp_customize ) {

		// 32a. custom svg logo
		$wp_customize->add_setting('logo_svg', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
		));

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_svg', array(
			'label' => __( 'SVG (retina) Logo', 'dbllc' ),
			'section' => 'title_tagline',
			'settings' => 'logo_svg',
			'priority' => 1,
		)));


	  // 32b. png fallback logo
		$wp_customize->add_setting('logo_png_fallback', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => get_bloginfo('template_directory') . '/img/logo-local.png',
		));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_png_fallback', array(
			'label' => __( 'Logo PNG Fallback', 'dbllc' ),
			'section' => 'title_tagline',
			'settings' => 'logo_png_fallback',
			'description' => __( 'For older browsers &amp; devices' ),
			'priority' => 8,
		)));

}
add_action( 'customize_register', 'dbllc_customize_register');



// 33. modifications to get_the_archive_title
//    src: https://wordpress.stackexchange.com/posts/175903/revisions
add_filter( 'get_the_archive_title', function ( $title ) {

    if( is_category() ) {
			$title = single_cat_title( 'Category: ', false );
    }

		elseif ( is_tag() ) {
			$title = single_tag_title( 'Tagged: ', false);
		}

		elseif( is_date() ) {
			$title = get_the_date('F Y') . ' ';
		}

		else {
			$title = ('Archive ');
		}

    return $title;

});



// 34. removing default sitemap
add_filter('wp_sitemaps_enabled', '__return_false');
