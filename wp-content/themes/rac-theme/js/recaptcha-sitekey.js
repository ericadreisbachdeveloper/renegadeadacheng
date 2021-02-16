// contains unique data-sitekey
// get sitekeys at https://www.google.com/recaptcha/admin
var recaptcha = '<div class="g-recaptcha" data-sitekey="6LfnSBYUAAAAALMf2iaqhqPEZmHXSpIdWW7GyaKE" data-callback="enableBtn"></div>';
jQuery(document).ready(function(){
	jQuery(recaptcha).insertBefore(jQuery('.login-submit'));
});


// disable Log In button until user passes reCAPTCHA
document.getElementById("wp-submit").disabled = true;
function enableBtn(){ document.getElementById('wp-submit').disabled = false; }
