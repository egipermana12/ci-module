/**
 * Written by: Agus Prawoto Hadi
 * Year      : 2020-2022
 * Website   : jagowebdev.com
 */

const cookie_jwd_adm_theme = Cookies.get("jwd_adm_theme");

jQuery(document).ready(function () {
    $("#mobile-menu-btn").click(function () {
        $("body").toggleClass("mobile-menu-show");
        if ($("body").hasClass("mobile-menu-show")) {
            Cookies.set("jwd_adm_mobile", "1");
        } else {
            Cookies.set("jwd_adm_mobile", "0");
        }
        return false;
    });
});
