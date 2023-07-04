(function ($) {
  $.fn.timepicker = function (options) {
    var settings = $.extend(
      {
        format: "HH:mm",
        step: 5,
      },
      options
    );

    //return fungsi
    return this.each(function () {
      var $input = $(this);
      var $timepicker = $(
        '<div class="timepicker">' +
          '<select class="timepicker-hour" size="3"></select> : ' +
          '<select class="timepicker-minute" size="3"></select>' +
          "</div>"
      );

      // Buat dropdown untuk jam
      var $hourDropdown = $timepicker.find(".timepicker-hour");
      for (var hour = 0; hour < 24; hour++) {
        var hourText = hour < 10 ? "0" + hour : hour;
        $hourDropdown.append(
          '<option value="' + hourText + '">' + hourText + "</option>"
        );
      }

      // Buat dropdown untuk menit
      var $minuteDropdown = $timepicker.find(".timepicker-minute");
      for (var minute = 0; minute < 60; minute += settings.step) {
        var minuteText = minute < 10 ? "0" + minute : minute;
        $minuteDropdown.append(
          '<option value="' + minuteText + '">' + minuteText + "</option>"
        );
      }

      $timepicker.insertAfter($input);

      $timepicker.hide(); //untuk hide awal

      $input.on("click", function () {
        $timepicker.show();
      });

      $timepicker.on("change", "select", function () {
        var hour = $hourDropdown.val();
        var minute = $minuteDropdown.val();
        var time = hour + ":" + minute;
        $input.val(time);
      });

      $(document).on("click", function (e) {
        if (
          !$input.is(e.target) &&
          !$timepicker.is(e.target) &&
          $timepicker.has(e.target).length === 0
        ) {
          $timepicker.hide();
        }
      });
    });
  };
})(jQuery);
