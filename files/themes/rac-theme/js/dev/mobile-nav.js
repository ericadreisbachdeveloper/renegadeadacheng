// minified with https://javascript-minifier.com/
// output to js/mobile-nav.min.js


// 1. Vanilla JS - Add two-part closing animation to navbar toggler
var navtoggle = document.getElementById('nav-toggle');
var navmenu   = document.getElementById('navmenu');

navtoggle.addEventListener('click', function(e) {

  // click turns toggle back to hamburger
  if( navmenu.classList.contains("show")) {

    navtoggle.classList.add('user-collapsed');
    navtoggle.classList.add('collapsed');
    navtoggle.setAttribute('aria-expanded', 'false');

    navmenu.classList.remove('show');
    navmenu.classList.add('collapsed');
    navmenu.setAttribute('aria-expanded', 'false');
    navmenu.style.zIndex="unset";
    navmenu.style.backgroundColor="transparent";
  }


  // click turns toggle to x
  else {

    navtoggle.classList.remove('collapsed');
    navtoggle.setAttribute('aria-expanded', 'true');

    navmenu.classList.add('show');
    navmenu.classList.remove('collapsed');
    navmenu.setAttribute('aria-expanded', 'true');
    navmenu.style.zIndex="9999";
    navmenu.style.backgroundColor="white";
  }

});



// 2. Vanilla JS - Show subnavs on mobile by clicking .open-submenu-a carets
document.querySelectorAll('.open-submenu-a').forEach(item => {
  item.addEventListener('click', event => {

    if ( item.classList.contains('mobile-show-submenu')) {
      item.classList.remove('mobile-show-submenu');
    }
    else {
      item.classList.add('mobile-show-submenu');
    }

  })
});




// 3. Vanilla JS - Show subnav on mobile if clicked a menu link with href="#"
document.querySelectorAll('.navbar-nav li a[href="#"]').forEach(item => {
  item.addEventListener('click', event => {
    var opencaret = item.parentNode.querySelectorAll('.open-submenu-a');
    var opencaret = opencaret[0];

    if(opencaret.classList.contains('mobile-show-submenu')) {
      opencaret.classList.remove('mobile-show-submenu');
    }
    else {
      opencaret.classList.add('mobile-show-submenu');
    }

  })
});
