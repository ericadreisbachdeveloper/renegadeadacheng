// reCAPTCHA v2 inivisible
// get sitekey at https://www.google.com/recaptcha/admin
// from sj.ada.cheng@gmail.com account
// src https://developers.google.com/recaptcha/docs/invisible#auto_render


// with form id
function onSubmit(token) {
	document.getElementById("loginform").submit();
}

// with button id
jQuery(document).ready(function(){
	jQuery('#wp-submit').addClass('g-recaptcha').attr('data-sitekey', '6LdyE14aAAAAAAsiHd0-dYzpQ3G2vrz81wvROiSt').attr('data-callback', 'onSubmit').attr('data-action', 'submit');
});
