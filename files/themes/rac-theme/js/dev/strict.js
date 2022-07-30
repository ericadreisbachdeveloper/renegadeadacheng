// minified with https://javascript-minifier.com/
// output to js/strict.min.js

(function ($, root, undefined) {
	$(function () {



		'use strict';



		// YouTube + Vimeo embeds
		if ( $('.wp-block-embed') ) {
			$('.wp-block-embed').each(function(){

				// get rendered width
				var iframe_w = $(this).width();

				// get assigned width
				var iframew = $(this).find('iframe').attr('width');

				// get assigned height
				var iframeh = $(this).find('iframe').attr('height');

				// re-render height
				//var iframe_h = iframeh * iframe_w / iframew;
				$(this).find('iframe').height(iframeh * iframe_w / iframew);
			});
		}



		// lavender image buttons
		$('.-img-button figure figcaption').on('click', function(){
			window.location = jQuery(this).parent('figure').find('a').attr('href');
		});




		// Wordpress login form
		if ( $('form[id^="loginform"]').length > 0 )  {

			 $('form[id^="loginform"]').find('label').each(function(){
				var for_attr = jQuery(this).attr('for');
				var text = jQuery(this).html();

				jQuery('input#' + for_attr).attr('placeholder', text);
			});
		}




		// If viewing a child page
		// show its containing submenu on mobile by default
		if ( $('.current-menu-item').parent('ul').hasClass('sub-menu') ) {
			$('.current-menu-item').parent('ul').parent('li').find('.open-submenu-a').addClass('mobile-show-submenu');
		}


		// If viewing a parent page
		// show its child submenu on mobile by default
		if ( $('.current-menu-item').hasClass('menu-item-has-children') ) {
			 $('.current-menu-item .open-submenu-a').addClass('mobile-show-submenu');
		}



		// Toggle search form on desktop upon clicking magnifying glass icon in header
		$('[data-display-search]').on('click', function(){
			if($(this).attr('aria-pressed') == "false") {
				$(this).attr('aria-pressed', 'true');
				$('#nav-search').focus();
 			}
			else {
				$(this).attr('aria-pressed', 'false');
			}
			return false;
		});


		// Links in menu with id including the word "social" open in new window
		$('.menu[id*="social"]').find('li').each(function() {
			$(this).find('a').attr('target', '_blank').attr('rel', 'noopener');
		});



		// Clicking links that are strictly hash (href="#") does nothing
		// ... unless it's the display search button
		$('a[href="#"]').not('[data-display-search]').on('click', function(){
			return false;
		});


	});
})(jQuery, this);
