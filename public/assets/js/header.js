/**
 * Written by: Agus Prawoto Hadi
 * Year      : 2020-2022
 * Website   : jagowebdev.com
 */

const cookie_jwd_adm_theme = Cookies.get("jwd_adm_theme");

var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader("X-CSRF-Token", csrfHash);
});

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

function Load_Loading() {
    $("#TukLoading").html(
        '<div class="position-fixed t-0 l-0 w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 1060; background: rgba(0,0,0,0.4);" > <div class="spinner-border text-danger" role="status"> <span class="sr-only">Loading...</span> </div> </div>'
    );
}

function Clear_Loading() {
    $("#TukLoading").html("");
}

function Load_Section() {
    $("#loadingSegment").html(
        '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="text-primary">Loading ...</p>'
    );
}

function Clear_Section() {
    $("#loadingSegment").html("");
}

function Peringatan(val) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: val,
    });
}

function Berhasil(val) {
    Swal.fire({
        icon: "success",
        title: "Berhasil",
        text: val,
    });
}

/**
 *untuk format currency
 * */
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g, "");
    if (isNaN(num)) num = "0";
    sign = num == (num = Math.abs(num));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10) cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num =
            num.substring(0, num.length - (4 * i + 3)) +
            "." +
            num.substring(num.length - (4 * i + 3));
    return (sign ? "" : "-") + "" + num + "," + cents;
}

/**
 *handle input harga
 * */
function inputCurrency(name) {
    var angka = document.getElementById(name + "_Uang").value;
    var res = angka.split(",");
    var harga = res[0].replace(/\./g, "");
    harga_new = parseInt(harga);
    belakangkoma1 = res[1] != undefined ? "," + res[1] : "";
    belakangkoma2 = res[1] != undefined ? "." + res[1] : "";
    hrg_tmpl = formatCurrency(harga_new);
    hrg_tmpl = hrg_tmpl.split(",");
    $("#" + name + "_Uang").val(hrg_tmpl[0] + "" + belakangkoma1);
    $("#" + name).val(harga + "" + belakangkoma2);
}

/**
 *cek apakah input number
 * */
function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 44) {
        return false;
    }
    return true;
}

function confirmDelete(id, title, text, confirmText, url) {
    Swal.fire({
        title: title,
        text: text + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmText,
    }).then((result) => {
        if (result.isConfirmed) {
            Load_Loading();
            $.ajax({
                type: "POST",
                url: url,
                data: { [csrfName]: csrfHash, id: id },
                success: function (res) {
                    load();
                    Clear_Loading();
                    Berhasil(res.messages);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(
                        xhr.status +
                            "\n" +
                            xhr.responseText +
                            "\n" +
                            thrownError
                    );
                },
            });
        }
    });
}
