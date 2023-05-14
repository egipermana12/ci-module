$(document).ready(function (e) {
    /**
     * toggle show hide password
     */
    $(".show_hide #toggle_password").click(function (e) {
        e.preventDefault();
        if ($(".show_hide input").attr("type") == "text") {
            $(".show_hide input").attr("type", "password");
            $(".show_hide #icon i").addClass("fa-eye-slash");
            $(".show_hide #icon i").removeClass("fa-eye");
        } else if ($(".show_hide input").attr("type") == "password") {
            $(".show_hide input").attr("type", "text");
            $(".show_hide #icon i").removeClass("fa-eye-slash");
            $(".show_hide #icon i").addClass("fa-eye");
        }
    });
});
