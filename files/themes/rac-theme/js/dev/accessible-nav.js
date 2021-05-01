// minified with https://javascript-minifier.com/
// included in functions.php
window.addEventListener('load', (e) => {
    (jQuery.fn.accessibleDropDown = function () {
        var e = jQuery(this);
        jQuery("li", e)
            .mouseover(function () {
                jQuery(this).addClass("hover");
            })
            .mouseout(function () {
                jQuery(this).removeClass("hover");
            }),
            jQuery("a", e)
                .focus(function () {
                    jQuery(this).parents("li").addClass("show");
                })
                .blur(function () {
                    jQuery(this).parents("li").removeClass("show");
                });
    }),
        jQuery(".nav").accessibleDropDown();
});
