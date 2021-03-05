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



<!-- <link href="//www.google-analytics.com" rel="dns-prefetch"> -->


<!-- Social / Open Graph -->
<meta name="og:url" property="og:url" content="<?php echo _e(get_permalink(), 'dbllc'); ?>">
<meta name="og:type" property="og:type" content="website">
<meta name="og:site_name" property="og:site_name" content="<?php echo get_bloginfo('name'); echo _e(' | '); _e(get_bloginfo('description')); ?>">


<?php $title = '';

	// 1. Home
	if(is_front_page()) { $title = get_bloginfo('name') . ' | ' . get_bloginfo('description'); }

	// 2. Search results
	elseif(is_search()) { $title = 'Search Results for &ldquo;' . get_search_query() . '&rdquo; | ' . get_bloginfo('name'); }

	// 3. Blog
	elseif(is_home()) { $title = 'Blog' . ' | ' . get_bloginfo('description'); }

	// 4. Author
	elseif(is_author()) { $author = get_the_author_meta('display_name');
		                 $title = "Author: " . $author . ' | ' . get_bloginfo('name'); }

	// 5. Archives
	elseif(is_archive()) { $title = get_the_archive_title()  . ' | ' . get_bloginfo('name'); }

	// 6. 404
	elseif(is_404()) { $title = 'Not Found | ' . get_bloginfo('name'); }

	// ... everything else
	else                { $title = get_the_title() . ' | ' . get_bloginfo('name'); }
?>

<title><?php _e($title); ?></title>
<meta name="og:title" property="og:title" content="<?php _e($title); ?>">
<meta name="twitter:title" content="<?php bloginfo('name'); _e(' | ' . get_bloginfo('description'), 'dbllc'); ?>">


<?php if(class_exists('acf') && get_field('meta-description')) : ?>
<meta name="description" property="description" content="<?php the_field('meta-description'); ?>">
<meta property="og:description" content="<?php if(isset($metadescription)) { echo $metadescription; } ?>" />
<meta name="twitter:description" content="<?php the_field('meta-description'); ?>">

<?php elseif(class_exists('acf') && get_field('social-txt', 'option')) : ?>
<meta name="description" property="description" content="<?php the_field('social-txt', 'option'); ?>">
<meta name="twitter:description" content="<?php the_field('social-txt','option'); ?>">
<?php endif; ?>


<?php if(has_post_thumbnail()) : ?>
<?php $socialimg = get_the_post_thumbnail_url($post->ID,'hero'); ?>
<meta name="og:image" property="og:image" content="<?php echo esc_url($socialimg); ?>">
<meta name="twitter:image" content="<?php echo esc_url($socialimg); ?>">

<?php elseif(class_exists('acf') && get_field('social-img','option')) : ?>
<?php $socialimg = get_field('social-img', 'option'); ?>
<meta name="og:image" property="og:image" content="<?php echo esc_url($socialimg['url']); ?>">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="<?php echo esc_url($socialimg['url']); ?>">

<?php endif; ?>



<!-- Favicons -->
<?php include('favicons.php'); ?>
<link href="<?= esc_url(TDIR); ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">



<!-- Google Analytics -->
<link href="//www.google-analytics.com" rel="dns-prefetch">



<!-- pre-load assets -->
<?php global $style_vsn; ?>
<link rel="preload" href="<?= esc_url(TDIR); ?>/css/style.css?ver=<?php _e($style_vsn); ?>" as="style">

<link rel="stylesheet" href="<?= esc_url(TDIR); ?>/css/style.css?ver=<?php _e($style_vsn); ?>" />

<link rel="stylesheet" href="<?php esc_url(get_site_url()); ; ?>/wp-includes/css/dist/block-library/style.min.css" media="print" onload="this.media='all'">

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



<!-- clip-path support -->
<!-- unminified version in THEME/js/dev -->
<script>var areClipPathShapesSupported=function(){for(var t="clipPath",e=["webkit","moz","ms","o"],a=[t],r=document.createElement("testelement"),p=0,l=e.length;p<l;p++){var o=e[p]+t.charAt(0).toUpperCase()+t.slice(1);a.push(o)}for(p=0,l=a.length;p<l;p++){var n=a[p];if(""===r.style[n]&&(r.style[n]="polygon(50% 0%, 0% 100%, 100% 100%)",""!==r.style[n]))return!0}return!1};areClipPathShapesSupported()||document.body.setAttribute("data-clippath","no-clippath");</script>



<?php wp_head(); ?>



</head>

<!-- default assumption - browser supports inline svgs - a reasonable assumption: https://caniuse.com/?search=svg -->
<body <?php body_class(); ?> data-svg="inlinesvg" data-clippath="clippath">



	<!-- 1. detect SVG support and update <body> attribute if needed - unminified version in THEME/js/dev/svg-support.js -->
	<!-- 2. add .-cssloaded to <body> after style.css loads - unminified vsn in THEME/js/dev/cssloaded.js -->
	<!-- 3. detect clip-path support and update <body> attribute if needed - unminified in THEME/js/dev/clip-path-support.js -->
	<script>
	document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image","1.1")||document.body.setAttribute("data-svg","no-inlinesvg");
	<?php global $style_vsn; ?>
	jQuery(document).ready(function () {
	var style_vsn="<?= $style_vsn; ?>",tdir="<?= esc_url(TDIR); ?>",e=document.getElementsByTagName("head")[0],t=document.body,d=document.createElement("link"),n=document.createElement("img"),r=tdir+"/css/style.css?ver="+style_vsn;d.href=r,d.rel="stylesheet",e.appendChild(d),n.onerror=function(){jQuery("body").addClass("-cssloaded"),t.removeChild(n)},t.appendChild(n),n.src=r;
	});
	</script>

	<script src="<?= esc_url(TDIR); ?>/js/dev/clip-path-support.js"></script>


	<a href="#main" id="skip-link" class="sr-only-focusable">Skip to main content</a>


	<div class="wrapper">


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
