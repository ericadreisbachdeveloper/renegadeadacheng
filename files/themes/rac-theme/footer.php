<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
</div><!-- /.wrapper -->



<footer class="site-footer">


	<!-- if is single, show navigation -->
	<?php if(is_single()) { include(locate_template('template/pagination_single.php')); } ?>


	<!-- if is a child page, show navigation-->
	<?php include(locate_template('template/pagination_from_menu.php')); ?>


	<div class="container-fluid footer-social-container">
		<div class="container">
			<div class="row footer-widgets-row">
				<?php if(is_active_sidebar('Footer Widgets')) { dynamic_sidebar( 'Footer Widgets' ); } ?>
			</div>
		</div>
	</div>


	<div class="container-fluid footer-brand-container">
		<div class="container">
			<div class="row footer-menus-row">

				<!-- logo -->
				<div class="col-sm-6">
					<a href="<?= esc_url(get_home_url()); ?>" class="footer-logo-a" title="Renegade Ada Cheng | Chicago-based Taiwanese Storyteller, Producer, Speaker | Home"></a>
				</div>

				<!-- copyright -->
				<?php if(is_active_sidebar('Copyright')) { dynamic_sidebar('Copyright'); } ?>

			</div>
		</div>
	</div>


</footer>



<?php wp_footer(); ?>


<!-- 1. detect SVG support and update <body> attribute if needed - unminified version in THEME/js/dev/svg-support.js -->
<script>
document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image","1.1")||document.body.setAttribute("data-svg","no-inlinesvg");
</script>

<!-- 2. detect clip-path support and update <body> attribute if needed - unminified in THEME/js/dev/clip-path-support.js -->
<!-- unminified version in THEME/js/dev -->
<script>var areClipPathShapesSupported=function(){for(var t="clipPath",e=["webkit","moz","ms","o"],a=[t],r=document.createElement("testelement"),p=0,l=e.length;p<l;p++){var o=e[p]+t.charAt(0).toUpperCase()+t.slice(1);a.push(o)}for(p=0,l=a.length;p<l;p++){var n=a[p];if(""===r.style[n]&&(r.style[n]="polygon(50% 0%, 0% 100%, 100% 100%)",""!==r.style[n]))return!0}return!1};areClipPathShapesSupported()||document.body.setAttribute("data-clippath","no-clippath");</script>


</body>
</html>
