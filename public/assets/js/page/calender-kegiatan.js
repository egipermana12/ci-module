var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader("X-CSRF-Token", csrfHash);
});

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

    $("#btn-baru").click(function (e) {
        e.preventDefault(e);
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "Kegiatan/new",
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
});

function load() {
    table.ajax.reload();
}

function edit(id) {
    Load_Loading();
    $.ajax({
        type: "POST",
        url: "Kegiatan/edit/" + id,
        data: { [csrfName]: csrfHash },
        success: function (res) {
            Clear_Loading();
            $(".tampilModal").html(res.data);
            $("#staticBackdrop").modal("show");
            $("#staticBackdrop").appendTo("body");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}

function hapus(id) {
    Swal.fire({
        title: "Hapus Data Kegiatan?",
        text: "Yakin hapus data kegiatan dengan ID : " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus data!",
    }).then((result) => {
        if (result.isConfirmed) {
            Load_Loading();
            $.ajax({
                type: "POST",
                url: "Kegiatan/delete",
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
