/**
 * Written by: Agus Prawoto Hadi
 * Year      : 2020-2022
 * Website   : jagowebdev.com
 */

const cookie_jwd_adm_theme = Cookies.get("jwd_adm_theme");

jQuery(document).ready(function () {
    /**
     * untuk sidebar jika mempunyai child
     * @return {[type]}     [description]
     */
    $(".has-children")
        .mouseenter(function () {
            $(this).children("ul").stop(true, true).fadeIn("fast");
        })
        .mouseleave(function () {
            $(this).children("ul").stop(true, true).fadeOut("fast");
        });

    $(".has-children").click(function () {
        var $this = $(this);

        $(this)
            .next()
            .stop(true, true)
            .slideToggle("fast", function () {
                $this.parent().toggleClass("tree-open");
            });
        return false;
    });

    /**
     * setup awal body header
     * @param  {[type]} ){                 } [description]
     * @return {[type]}     [description]
     */
    $("body").delegate(".nav-theme-option button", "click", function () {
        $this = $(this);
        $ul = $this.parents("ul").eq(0);
        $icon = $this.children(".bi:not(.check)").clone().removeClass("me-2"); //untuk remove active class pada light or black
        $link = $ul.prev().empty();
        $link.append($icon);
        $ul.find("button").removeClass("active");

        $this.addClass("active");
        theme_value = $(this).attr("data-theme-value"); //ambil theme value dari pilihan light or black
        theme_color = "";
        theme_current = Cookies.get("jwd_adm_theme");
        if (theme_value == "system") {
            if (
                window.matchMedia &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            ) {
                theme_color = "dark";
            } else {
                theme_color = "light";
            }
            Cookies.set("jwd_adm_theme_system", "true");
        } else {
            theme_color = theme_value;
            Cookies.set("jwd_adm_theme_system", "false");
        }
        $("html").attr("data-bs-theme", theme_color);
        Cookies.set("jwd_adm_theme", theme_color);
    });

    window
        .matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", function (e) {
            theme_system = Cookies.get("jwd_adm_theme_system");
            if (theme_system == "true") {
                color = e.matches ? "dark" : "light";
                $("html").attr("data-bs-theme", color);
                Cookies.set("jwd_adm_theme", color);
            }
        });

    /**
     * untuk toggle sidebar saat versi mobile
     * @param
     * @return {[type]}   [description]
     */
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
