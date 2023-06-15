$(document).ready(function () {
    var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
    var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH
    $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
        jqXHR.setRequestHeader("X-CSRF-Token", csrfHash);
    });
    table = $("#data-tables").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "Kegiatan/fetchData",
            data: function (d) {
                d.id_label = $("#selectLabel").val();
            },
        },
        order: [],
        columns: [
            { data: "no", orderable: false },
            { data: "tgl_mulai_kegiatan" },
            { data: "tgl_selesai_kegiatan" },
            { data: "nm_kegiatan" },
            { data: "aksi", orderable: false },
        ],
        language: {
            paginate: {
                next: '<i class="fa-solid fa-chevron-right"></i>', // or '>'
                previous: '<i class="fa-solid fa-chevron-left"></i>', // or '<'
            },
            lengthMenu: "_MENU_",
            zeroRecords: "Data Tidak Ditemukan",
            infoEmpty: "Data Tidak Ditemukan",
            infoFiltered: "",
            search: "",
        },
        dom:
            "<'row align-items-center'<'col-sm-6'><'col-sm-6'f>>" +
            "<'row'<'col-sm-12't>>" +
            "<'row mt-2 align-items-center'<'col-sm-4 d-flex justify-content-start align-items-center gap-2'li><'col-sm-8'p>>" +
            "<'row'<'col-sm-12 text-center'<'loading-indicator'>r>>",
    });

    $("#selectLabel").change(function (event) {
        table.ajax.reload();
    });
    // loadSelectOptions("LabelKalender/getSelectOption", ".select-container"); sementara tidak di pakai, error pada saat load awal pindah ke index
});

function loadSelectOptions(url, selectContainer) {
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (response) {
            var selectOptions = response.selectOptions;

            var selectHtml =
                '<select id="filter-kategori" name="id_label" class="form-select form-select-sm">';
            selectHtml += '<option value="">Cari Kategori</option>';
            for (var i = 0; i < selectOptions.length; i++) {
                selectHtml +=
                    '<option value="' +
                    selectOptions[i].id +
                    '">' +
                    selectOptions[i].nm_label +
                    "</option>";
            }
            selectHtml += "</select>";

            $(selectContainer).html(selectHtml);
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}
