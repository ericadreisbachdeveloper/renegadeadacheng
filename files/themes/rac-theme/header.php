<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<?php function sanitize_output($buffer) {
	require_once('minify/html.php');
  $buffer = Minify_HTML::minify($buffer);
  return $buffer;
}
ob_start('sanitize_output'); ?>


<meta charset="<?php bloginfo('charset'); ?>">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<!--
<title><?php //wp_title(''); ?></title>
<?php //do_action( 'wpseo_head' );  ?> -->



<!-- Social / Open Graph -->
<?php global $page_url; $page_url = "";
	if(is_search()) {
		$page_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; }
	elseif(is_home()) {
		$page_url = esc_url(get_permalink(get_option('page_for_posts')));
	}
	else {
		$page_url = esc_url(get_permalink()); }
?>
<meta name="og:url" property="og:url" content="<?php _e($page_url); ?>">
<meta name="og:type" property="og:type" content="website">
<meta name="og:site_name" property="og:site_name" content="<?php echo get_bloginfo('name'); echo _e(' | '); _e(get_bloginfo('description')); ?>">



<!-- Title -->
<?php global $title, $page_title; $title = ""; $pagetitle = ""; $posttype_lower = ""; $posttype = "";

			// $title is more verbose, better for search results title and browser titles
			// $page_title is more bare, better for breadcrumbs
			if(is_front_page()) { $page_title == 'Home'; }
			elseif(is_search()) { $page_title = 'Search Results for &ldquo;' . $GLOBALS['wp_query']->query['s'] . '&rdquo;'; }
	    elseif(is_home())   { $page_title = 'Storytelling Videos'; }
	    else                { $page_title = get_the_title(); }

			if (get_post_type() == 'post') { $posttype = 'Storytelling Videos'; }
	  else { $posttype_lower = get_post_type(); $posttype = strtoupper($posttype_lower); }

 		  $cat_obj = ""; $cat = "";
		  if(is_category()) {
	 	  	$cat_obj = get_queried_object(); $cat = $cat_obj->name;
  		}

      if(is_front_page())   { $title = get_bloginfo('name') . ' | ' . get_bloginfo('description'); }
			elseif(is_404())      { $title = 'Page not found | ' . get_bloginfo('name'); }
			elseif(is_search())   { $title = 'Search Results | ' . get_bloginfo('name'); }
			elseif(is_home())     { $title = 'Storytelling Videos | ' . get_bloginfo('name'); }
			elseif(is_category()) { $title = $posttype . ': ' . $cat . ' | ' . get_bloginfo('name'); }
			elseif(is_tag())      { $title = 'Tagged: ' . $cat . ' | ' . get_bloginfo('name'); }
			elseif(is_archive())  { $title =  $posttype . ' | ' . get_bloginfo('name'); }
			else                  { $title = get_the_title() . ' | ' . get_bloginfo('name'); }
?>

<title><?php _e($title); ?></title>
<meta property="og:title" content="<?php _e($title); ?>" />
<meta name="twitter:title" content="<?php _e($title); ?>" />



<meta name="twitter:card" content="summary_large_image" />



<!-- Meta Description -->
<?php global $metadescription; $metadescription = ""; ?>

<!-- 1st choice - post meta description field -->
<!-- archives don't have descriptions -->
<?php global $post_id; $post_id = ''; $post_id = $post->ID; ?>
<?php if(!is_archive() && !is_search() && class_exists('acf') && get_field('meta-description', $post->ID)) : ?>
<?php $metadescription = get_field('meta-description'); $metadescription = str_replace('"', '', $metadescription); ?>

<!-- 2nd choice - Wordpress-generated excerpt -->
<!-- default 404 doesn't have a description -->
<!-- archives don't have descriptions -->
<?php elseif(!is_404() && !is_archive() && !is_search()) : ?>
<?php $metadescription = dbllc_excerpt($post->ID);  ?>

<?php endif; ?>

<meta name="description" property="description" content="<?php _e($metadescription); ?>">
<meta property="og:description" content="<?php _e($metadescription); ?>" />
<meta name="twitter:description" content="<?php _e($metadescription); ?>">



<!-- Image -->
<?php global $socialimg, $socialimg_id, $socialimg_h, $socialimg_w, $socialimg_alt,
      $global_socialimg, $global_socialimg_h, $global_socialimg_w, $global_socialimg_alt;

			// reset variables likely to change from page to page
			// in Schema these are used for #primaryimage
			$socialimg = ""; $socialimg_id = ""; $socialimg_h = ""; $socialimg_w = ""; $socialimg_alt = "";

			// set global
			$global_socialimg     = get_field('social-img', 'option');

			$global_socialimg_w   = $global_socialimg['width'];
			$global_socialimg_h   = $global_socialimg['height'];
			$global_socialimg_alt = esc_attr($global_socialimg['alt']);

			$global_socialimg = esc_url($global_socialimg['url']); ?>


<!-- 1st choice - not 404, not search, not archive, has featured image -->
<?php if(!is_404() && !is_search() && !is_archive() && has_post_thumbnail($post->ID)) : ?>
<?php
  $socialimg_id = get_post_thumbnail_id($post->ID);
	$socialimg = wp_get_attachment_image_src($socialimg_id, 'hero')[0];
	$socialimg = esc_url($socialimg);
	$socialimg_w = wp_get_attachment_image_src($socialimg_id, 'hero')[1];
	$socialimg_h = wp_get_attachment_image_src($socialimg_id, 'hero')[2];
	$socialimg_alt = esc_attr(get_post_meta($socialimg_id  , '_wp_attachment_image_alt', true));
?>


<!-- 2nd choice - global default -->
<?php elseif(class_exists('acf') && get_field('social-img','option')) : ?>
<?php
		$socialimg     = $global_socialimg;
		$socialimg_h   = $global_socialimg_h;
		$socialimg_w   = $global_socialimg_w;
		$socialimg_alt = $global_socialimg_alt; ?>
<?php endif; ?>


<meta name="og:image" property="og:image" content="<?php _e($socialimg); ?>">
<meta name="twitter:image" content="<?php _e($socialimg); ?>">



<!-- Favicons -->
<?php include('favicons.php'); ?>
<link href="<?= esc_url(TDIR); ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">





<!-- pre-load + load assets -->

<!-- hero -->
<?php if(get_field('hero-img-preload')) : ?><link rel="preload" as="image" href="<?php $hero = get_field('hero-img-preload'); _e(esc_url($hero['url'])); ?>"><?php endif ; ?>


<!-- Wordpress blocks -->
<?php global $site_url; $site_url = esc_url(get_site_url()); ?>
<link rel="preload" href="<?php _e($site_url); ?>/wp-includes/css/dist/block-library/style.min.css" as="style">

<link rel="stylesheet" href="<?php _e($site_url); ?>/wp-includes/css/dist/block-library/style.min.css" />
<!-- noscript per https://web.dev/defer-non-critical-css/ -->


<!-- theme above-the-fold styles -->
<?php global $style_vsn; ?>
<link rel="preload" href="<?= esc_url(TDIR); ?>/css/style.css?ver=<?php _e($style_vsn); ?>" as="style" />
<!-- noscript per https://web.dev/defer-non-critical-css/ -->

<link rel="stylesheet" href="<?= esc_url(TDIR); ?>/css/style.css?ver=<?php _e($style_vsn); ?>" />


<link rel="preload" href="<?= esc_url(TDIR); ?>/webfonts/leaguespartan-bold.otf" as="font" type="font/otf" crossOrigin="anonymous">

<!-- unminified vsn in THEME/sass/zz-_fonts.scss -->
<style>@font-face{font-family:"Font Awesome 5 Solid";font-style:normal;font-weight:900;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.eot");src:url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.eot?#iefix") format("embedded-opentype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.woff2") format("woff2"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.woff") format("woff"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.ttf") format("truetype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.svg#fontawesome") format("svg")}@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:400;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.eot");src:url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.eot?#iefix") format("embedded-opentype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.woff2") format("woff2"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.woff") format("woff"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.ttf") format("truetype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.svg#fontawesome") format("svg")}@font-face{font-family:"Font Awesome Brands";font-style:normal;font-weight:400;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.eot");src:url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.eot?#iefix") format("embedded-opentype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.woff2") format("woff2"),url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.woff") format("woff"),url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.ttf") format("truetype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.svg#fontawesome") format("svg")}@font-face{font-family:"League Spartan";font-style:normal;font-weight:400;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/leaguespartan-bold.otf") format("opentype")}</style>



<?php $custom_logo_svg = get_theme_mod( 'logo_svg' );
      $custom_logo_png = get_theme_mod( 'logo_png_fallback' ); ?>

<?php if($custom_logo_svg) : ?>
<link rel="preload" as="image" href="<?= esc_url($custom_logo_svg); ?>">
<?php else : ?>
<link rel="preload" as="image" href="<?= esc_url(TDIR); ?>/img/logo.svg">
<?php endif; ?>

<style>.logo-a { background-image: url('<?= esc_url($custom_logo_png); ?>'); }</style>



<!-- Custom Schema -->
<?php if(isset($post)) {
	global $gmt_published, $gmt_modified;
 	$gmt_published =          get_the_time('c', $post->ID);
 	$gmt_modified  = get_the_modified_date('c', $post->ID);
	}


	global $cat_url, $cat_title; $cat = $cat_id = $cat_id = $cat_url = $cat_title = '';

	if(is_single() || is_archive()) {
		$cat = get_the_category();
		// use first category
		$cat_id = $cat[0]->term_id;
		$cat_title = $cat[0]->name;
		$cat_url = get_category_link( $cat_id);
	}

 include(locate_template('template/pagination_variables.php'));

 global $menu_items_menu_ids, $current_page_menu_object, $current_page_parent_menu_id, $menu_items_ids, $menu_items_titles, $menu_items_urls, $parent_title, $parent_url;

 // define parents for menu children
 if ($current_page_parent_menu_id !== '0') {
 	$key = array_search( $current_page_parent_menu_id, $menu_items_menu_ids);
	$parent_title = $menu_items_titles[$key];
	$parent_url = esc_url($menu_items_urls[$key]);
 }

 // define parents for single and archive posts
 elseif(is_single() || is_archive()) {
	 $parent_title = get_the_title(get_option('page_for_posts'));
	 $parent_url = esc_url(get_permalink(get_option('page_for_posts')));
 }

 include(locate_template('js/dev/schema.php'));

?>



<?php wp_head(); ?>



<!-- Global site tag (gtag.js) - Google Analytics - conditionally hidden from PageSpeed Insights -->
<?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-QHVPBX71VD"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-QHVPBX71VD');
</script>
<?php endif; ?>



</head>



<body <?php body_class(); ?> data-svg="inlinesvg" id="body">


	<a href="#main" id="skip-link" class="sr-only-focusable">Skip to main content</a>


	<div class="wrapper" data-footer="<?php global $data_footer; _e($data_footer); ?>">


		<!-- when this div is in frame -->
		<!-- AOS adds .aos-animate -->
		<!-- and CSS rules on .aos-animate + .site-header in _adaptive.scss add shadow -->
		<div class="viewport-height" data-aos="aos"></div>



		<header class="site-header clear">


			<div class="gutenberg-container">

				<div class="logo-div">
					<a href="<?php echo esc_url(get_home_url()); ?>" class="pngbg logo-a a">

						<?php if($custom_logo_svg) : ?>

							<?php $logo_id = attachment_url_to_postid( $custom_logo_svg);
							      $logo_w = wp_get_attachment_image_src($logo_id, 'full')[1];
										$logo_h = wp_get_attachment_image_src($logo_id, 'full')[2]; ?>

						<img height="<?= $logo_h; ?>" width="<?= $logo_w; ?>" class="logo-img" src="<?= esc_url($custom_logo_svg); ?>" title="<?= get_bloginfo('name'); ?>" alt="logo for <?= get_bloginfo('name'); ?>"/>

						<?php else : ?>
						<img height="80" width="160" class="logo-img" src="<?= esc_url(TDIR); ?>/img/logo.svg" title="<?= get_bloginfo('name'); ?>" alt="logo for <?= get_bloginfo('name'); ?>" />

						<?php endif; ?>

					</a>
				</div>


				<nav class="nav">

					<div class="navbar-header">
						<button class="navbar-toggler navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
							<span class="sr-only">Toggle navigation</span>
							<span class="opennav icon-bar -top"></span>
							<span class="opennav icon-bar -middle"></span>
							<span class="opennav icon-bar -bottom"></span>
						</button>
					</div>


					<div id="navmenu" class="navbar-collapse collapse">
						<div class="container-on-mobile">
							<!-- edit menu output in functions.php -->
							<?php dbllc_nav('main-menu'); ?>
							<?php include(locate_template('searchform.php')); ?>
						</div>
					</div>

				</nav>


			</div><!-- /.gutenberg-container -->
		</header>
