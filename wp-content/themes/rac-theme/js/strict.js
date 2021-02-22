(function ($, root, undefined) {
	$(function () {



		'use strict';



		// Wordpress login form
		if ( $('form[id^="loginform"]').length > 0 )  {

			 $('form[id^="loginform"]').find('label').each(function(){
				var for_attr = jQuery(this).attr('for');
				var text = jQuery(this).html();

				jQuery('input#' + for_attr).attr('placeholder', text);
			});
		}



		// Add two-part closing animation to navbar toggler
		$('button[data-target="#navmenu"]').on('click', function(){

			// the hamburger
			if( $('#navmenu').hasClass('show')) {
				$('button[data-target="#navmenu"]').addClass('user-collapsed');
				$('#navmenu').removeClass('show').attr('aria-expanded', 'false').addClass('collapsed');
				$('.navbar-toggler').attr('aria-expanded', 'false').addClass('collapsed');
			}

			// the x
			else {
				$('#navmenu').addClass('show').attr('aria-expanded', 'true').removeClass('collapsed');
				$('.navbar-toggler').attr('aria-expanded', 'true').removeClass('collapsed');
			}
		});



		//Show subnavs on mobile by clicking .open-submenu-a carets
		$('.open-submenu-a').on('click', function(){
			$(this).toggleClass('mobile-show-submenu');
			return false;
		});




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
		$('a[href="#display-search"]').on('click', function(){
			$('.search').toggleClass('show-search');
			$('#nav-search').focus();
			return false;
		});


		// Links in menu with id including the word "social" open in new window
		$('.menu[id*="social"]').find('li').each(function(){
			$(this).find('a').attr('target', '_blank').attr('rel', 'noopener');
		});



		// Clicking links that are strictly hash (href="#") does nothing
		$('a[href="#"]').on('click', function(){
			return false;
		});


	});
})(jQuery, this);
