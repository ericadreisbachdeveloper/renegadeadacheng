<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<?php function sanitize_output($buffer) {
	// minify html
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
<meta name="og:url" property="og:url" content="<?php echo _e(get_permalink(), 'dbllc'); ?>">
<meta name="og:type" property="og:type" content="website">
<meta name="og:site_name" property="og:site_name" content="<?php echo get_bloginfo('name'); echo _e(' | '); _e(get_bloginfo('description')); ?>">



<!-- Title -->
<?php $title = ""; $posttype_lower = ""; $posttype = "";

			if (get_post_type() == 'post') { $posttype = 'Blog'; }
	  else { $posttype_lower = get_post_type(); $posttype = strtoupper($posttype_lower); }

		$cat_obj = ""; $cat = "";
		$cat_obj = get_queried_object(); $cat = $cat_obj->name;

      if(is_front_page())   { $title = get_bloginfo('name') . ' | ' . get_bloginfo('description'); }
			elseif(is_404())      { $title = 'Page not found | ' . get_bloginfo('name'); }
			elseif(is_search())   { $title = 'Search Results | ' . get_bloginfo('name'); }
			elseif(is_category()) { $title = $posttype . ': ' . $cat . ' | ' . get_bloginfo('name'); }
			elseif(is_tag())      { $title = 'Tagged: ' . $cat . ' | ' . get_bloginfo('name'); }
			elseif(is_archive())  { $title =  $posttype . ' | ' . get_bloginfo('name'); }
			else                  { $title = get_the_title() . ' | ' . get_bloginfo('name'); }
?>

<title><?php _e($title); ?></title>
<meta property="og:title" content="<?php _e($title); ?>" />
<meta name="twitter:title" content="<?php _e($title); ?>" />



<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@healthyschools" />



<!-- Meta Description -->
<?php $metadescription = "";  ?>

<!-- 1st choice - post meta desription field -->
<!-- archives don't have descriptions -->
<?php if(!is_archive() && class_exists('acf') && get_field('meta-description', $post->ID)) : ?>
<?php $metadescription = get_field('meta-description'); ?>

<!-- 2nd choice - Wordpress-generated excerpt -->
<!-- default 404 doesn't have a description -->
<!-- archives don't have descriptions -->
<?php elseif(!is_404() && !is_archive()) : ?>
<?php $metadescription = dbllc_excerpt($post->ID);  ?>

<?php endif; ?>

<meta name="description" property="description" content="<?php _e($metadescription); ?>">
<meta property="og:description" content="<?php _e($metadescription); ?>" />
<meta name="twitter:description" content="<?php _e($metadescription); ?>">



<!-- Image -->
<?php $socialimg = ""; ?>

<!-- 1st choice - not archive, not 404, has featured image -->
<?php if(!is_404() && !is_archive() && has_post_thumbnail($post->ID)) : ?>
<?php $socialimg = get_the_post_thumbnail_url($post->ID,'hero'); ?>

<!-- 2nd choice - global default -->
<?php elseif(class_exists('acf') && get_field('social-img','option')) : ?>
<?php $socialimg = get_field('social-img', 'option', $post->ID); $socialimg = $socialimg['url']; ?>
<?php endif; ?>

<meta name="og:image" property="og:image" content="<?php echo esc_url($socialimg); ?>">
<meta name="twitter:image" content="<?php echo esc_url($socialimg); ?>">



<!-- Favicons -->
<?php include('favicons.php'); ?>
<link href="<?= esc_url(TDIR); ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">



<!-- Google Analytics -->
<link href="//www.google-analytics.com" rel="dns-prefetch">


<!-- Schema -->
<script defer type='application/ld+json'>
{
  "@context": "http://www.schema.org",
  "@type": "person",
  "name": "Ada Cheng",
  "jobTitle": "Storyteller",
  "gender": "female",
  "url": "https://renegadeadacheng.com",
  "sameAs": [
     "https://www.facebook.com/dr.adacheng/",
     ""
  ],
  "image": "https://adac1.sg-host.com/images/renegade-ada-cheng-190526.jpg",
  "address": {
     "@type": "PostalAddress",
     "addressLocality": "Chicago",
     "addressRegion": "Illinois"
  }
}
</script>



<!-- pre-load + load assets -->

<!-- Wordpress blocks -->
<link rel="preload" href="<?php esc_url(get_site_url()); ; ?>/wp-includes/css/dist/block-library/style.min.css" as="style">

<link rel="stylesheet" href="<?php esc_url(get_site_url()); ; ?>/wp-includes/css/dist/block-library/style.min.css" media="print" onload="this.media='all'">


<!-- theme above-the-fold styles -->
<?php global $style_vsn; ?>
<link rel="preload" href="<?= esc_url(TDIR); ?>/css/style.css?ver=<?php _e($style_vsn); ?>" as="style">

<link rel="stylesheet" href="<?= esc_url(TDIR); ?>/css/style.css?ver=<?php _e($style_vsn); ?>" />


<!-- theme "later" styles -->
<link rel="stylesheet" href="<?= esc_url(TDIR); ?>/css/later.css?ver=<?php _e($style_vsn); ?>" />



<link rel="preload" href="<?= esc_url(TDIR); ?>/webfonts/leaguespartan-bold.otf" as="font" type="font/otf" crossOrigin="anonymous">

<!-- unminified vsn in THEME/sass/_fonts.scss -->
<style>@font-face{font-family:"Font Awesome 5 Solid";font-style:normal;font-weight:900;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.eot");src:url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.eot?#iefix") format("embedded-opentype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.woff2") format("woff2"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.woff") format("woff"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.ttf") format("truetype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-solid-900.svg#fontawesome") format("svg")}@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:400;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.eot");src:url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.eot?#iefix") format("embedded-opentype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.woff2") format("woff2"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.woff") format("woff"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.ttf") format("truetype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-regular-400.svg#fontawesome") format("svg")}@font-face{font-family:"Font Awesome Brands";font-style:normal;font-weight:400;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.eot");src:url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.eot?#iefix") format("embedded-opentype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.woff2") format("woff2"),url(../webfonts/fa-brands-400.woff) format("woff"),url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.ttf") format("truetype"),url("<?= esc_url(TDIR); ?>/webfonts/fa-brands-400.svg#fontawesome") format("svg")}@font-face{font-family:"League Spartan";font-style:normal;font-weight:400;font-display:swap;src:url("<?= esc_url(TDIR); ?>/webfonts/leaguespartan-bold.otf") format("opentype")}</style>

<?php $custom_logo_svg = get_theme_mod( 'logo_svg' );
      $custom_logo_png = get_theme_mod( 'logo_png_fallback' ); ?>

<?php if($custom_logo_svg) : ?>
<link rel="preload" as="image" href="<?= esc_url($custom_logo_svg); ?>">
<?php else : ?>
<link rel="preload" as="image" href="<?= esc_url(TDIR); ?>/img/logo.svg">
<?php endif; ?>

<style>.logo-a { background-image: url('<?= esc_url($custom_logo_png); ?>'); }</style>



<?php wp_head(); ?>



</head>

<!-- default assumption - browser supports inline svgs - a reasonable assumption: https://caniuse.com/?search=svg -->
<body <?php body_class(); ?> data-svg="inlinesvg" data-clippath="clippath">



	<script src="<?= esc_url(TDIR); ?>/js/dev/clip-path-support.js"></script>


	<a href="#main" id="skip-link" class="sr-only-focusable">Skip to main content</a>


	<div class="wrapper" data-footer="<?php global $data_footer; include(locate_template('template/pagination_variables.php')); _e($data_footer); ?>">


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
