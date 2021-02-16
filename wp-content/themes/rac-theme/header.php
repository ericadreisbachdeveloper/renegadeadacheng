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

<?php //global $post; var_dump($post); ?>

<meta charset="<?php bloginfo('charset'); ?>">
<meta name="format-detection" content="telephone=no">
<!-- <meta http-equiv="X-U cA-Compatible" content="IE=edge"> -->
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
<link href="<?php _e(get_stylesheet_directory_uri(), 'dbllc'); ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">



<!-- Google Analytics -->
<link href="//www.google-analytics.com" rel="dns-prefetch">



<?php global $style_vsn; ?>
<link href="<?= esc_url(get_stylesheet_directory_uri()); ?>/css/style.css?ver=<?php _e($style_vsn); ?>" rel="stylesheet">



<?php wp_head(); ?>



</head>


<body <?php body_class(); ?>>


	<a href="#main" id="skip-link" class="sr-only sr-only-focusable">Skip to main content</a>


	<div class="wrapper">


		<header class="site-header clear">
			<div class="gutenberg-container">


				<?php $custom_logo_svg = get_theme_mod( 'logo_svg' ); ?>
				<?php $custom_logo_png = get_theme_mod( 'logo_png_fallback' ); ?>


				<div class="logo-div">
					<a href="<?php echo esc_url(get_home_url()); ?>" class="pngbg logo-a a">

						<?php if($custom_logo_svg) : ?>
						<img class="logo-img" src="<?= esc_url($custom_logo_svg); ?>" />

						<?php else : ?>
						<img class="logo-img" src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo.svg" />

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
							<?php dbllc_nav('main-menu'); ?>
							<?php include(locate_template('searchform.php')); ?>
						</div>
					</div>

				</nav>


			</div><!-- /.gutenberg-container -->
		</header>
