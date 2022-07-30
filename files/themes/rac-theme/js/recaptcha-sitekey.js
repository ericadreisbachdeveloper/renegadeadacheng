// reCAPTCHA v2 inivisible
// get sitekey at https://www.google.com/recaptcha/admin
// src https://developers.google.com/recaptcha/docs/invisible#auto_render


// with form id
function onSubmit(token) {
	document.getElementById("loginform").submit();
}

// with button id
jQuery(document).ready(function(){
	jQuery('#wp-submit').addClass('g-recaptcha').attr('data-sitekey', '6LfUtaceAAAAAKk48eX4kg7R02-GdQlw53kdL2Oy').attr('data-callback', 'onSubmit').attr('data-action', 'submit');
});
