var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader("X-CSRF-Token", csrfHash);
});

function tampilTable() {
    Load_Section();
    $.ajax({
        type: "POST",
        url: "Pegawai/view",
        data: { [csrfName]: csrfHash },
        // processData: false, // tell jQuery not to process the data
        // contentType: false, // tell jQuery not to set contentType
        success: function (data) {
            var res = eval("(" + data + ")");
            if (res.err == "") {
                $("#dataPegawai").html(res.content);
                Clear_Section();
            } else {
                alert(res.err);
            }
        },
    });
}

function tampilData() {
    table = $("#data-tables").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "Pegawai/fetchData",
            data: function (d) {
                d.id_label = $("#selectLabel").val();
            },
        },
        order: [],
        columns: [
            { data: "no", className: "text-center", orderable: false },
            { data: "aksi", className: "text-center", orderable: false },
            { data: "nm_pegawai" },
            { data: "alamat" },
            { data: "jns_kelamin" },
            { data: "nm_divisi" },
            { data: "nm_unit_kerja" },
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
}

$(document).ready(function () {
    tampilTable();

    $("#btn-baru").click(function (e) {
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "Pegawai/new",
            data: { [csrfName]: csrfHash },
            success: function (res) {
                Clear_Loading();
                $(".tampilModal").html(res.data);
                $("#staticBackdrop").modal("show");
                $("#staticBackdrop").appendTo("body");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(
                    xhr.status + "\n" + xhr.responseText + "\n" + thrownError
                );
            },
        });
    });

    $("#btn-edit").click(function (e) {
        e.preventDefault();
        /**
         * untuk handle checbox
         */
        let checked = [];
        $("input[name='pegawaicb']:checked").each(function () {
            checked.push($(this).val());
        });
        let length = $("input[name='pegawaicb']:checked").length;
        let dataCheck = checked.join(",");
        if (length != 1) {
            Peringatan("Harus pilih satu data!");
        } else {
            Load_Loading();
            console.log(dataCheck);
            $.ajax({
                type: "POST",
                url: "Pegawai/edit/" + dataCheck,
                data: { [csrfName]: csrfHash },
                success: function (res) {
                    Clear_Loading();
                    $(".tampilModal").html(res.data);
                    $("#staticBackdrop").modal("show");
                    $("#staticBackdrop").appendTo("body");
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
});
