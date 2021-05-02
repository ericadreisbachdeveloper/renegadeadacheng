<?php if ( ! defined( 'ABSPATH' ) ) {  exit; } ?>
</div><!-- /.wrapper -->



<footer class="site-footer">


	<!-- if is single, show navigation -->
	<?php if(is_single()) { include(locate_template('template/pagination_single.php')); } ?>


	<!-- show page-to-page navigation -->
	<?php if(!is_front_page()) { include(locate_template('template/pagination_from_menu.php')); }  ?>




</footer>



<?php wp_footer(); ?>



<!-- theme "later" styles -->
<?php global $style_vsn; ?>
<style>
<?php _e(file_get_contents(TDIR . '/css/later.css')); ?>
</style>



<!-- detect SVG support and update <body> attribute if needed - unminified version in THEME/js/dev/svg-support.js -->
<script>
document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image","1.1")||document.body.setAttribute("data-svg","no-inlinesvg");
</script>



</body>
</html>
