// reCAPTCHA v3
// get sitekey at https://www.google.com/recaptcha/admin
// src https://developers.google.com/recaptcha/docs/v3
// from sj.ada.cheng@gmail.com account


// with form id
function onSubmit(token) {
	document.getElementById("wpforms-form-145").submit();
	//document.getElementsByClassName("wpforms-form").submit();
}

// with button id
jQuery(document).ready(function(){

	jQuery("[name='wpforms[submit]']").addClass('g-recaptcha').attr('data-sitekey', '6LdyE14aAAAAAAsiHd0-dYzpQ3G2vrz81wvROiSt').attr('data-callback', 'onSubmit').attr('data-action', 'submit');

	/* jQuery('#wp-submit').addClass('g-recaptcha').attr('data-sitekey', '6LdyE14aAAAAAAsiHd0-dYzpQ3G2vrz81wvROiSt').attr('data-callback', 'onSubmit').attr('data-action', 'submit'); */
});
