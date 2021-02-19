// reCAPTCHA v3
// src https://developers.google.com/recaptcha/docs/v3

function onSubmit(token) {
	document.getElementById("loginform").submit();
}

jQuery(document).ready(function(){
	jQuery('#wp-submit').addClass('g-recaptcha').attr('data-sitekey', '6LdyE14aAAAAAAsiHd0-dYzpQ3G2vrz81wvROiSt').attr('data-callback', 'onSubmit').attr('data-action', 'submit');
});






// reCAPTCHA v2
// get sitekeys at https://www.google.com/recaptcha/admin

/*
var recaptcha = '<div class="g-recaptcha" data-sitekey="XXXXXX" data-callback="enableBtn"></div>';
jQuery(document).ready(function(){
	jQuery(recaptcha).insertBefore(jQuery('#loginform'));
});
*/


// disable Log In button until user passes reCAPTCHA
// document.getElementById("wp-submit").disabled = true;
// function enableBtn(){ document.getElementById('wp-submit').disabled = false; }
