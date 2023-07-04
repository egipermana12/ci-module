var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader("X-CSRF-Token", csrfHash);
});

$(document).ready(function () {
    table = $("#data-tables").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "Jamkerja/fetchData",
        },
        order: [],
        columns: [
            { data: "no", className: "text-center", orderable: false },
            { data: "aksi", className: "text-center", orderable: false },
            { data: "nm_shift" },
            { data: "jam_mulai_kerja", className: "text-center" },
            { data: "jam_selesai_kerja", className: "text-center" },
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

    $("#selectAll").click(function (e) {
        if ($(this).is(":checked")) {
            $(".jamcb").prop("checked", true);
        } else {
            $(".jamcb").prop("checked", false);
        }
    });

    $("#btn-baru").click(function (e) {
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "Jamkerja/new",
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
        $("input[name='jamcb']:checked").each(function () {
            checked.push($(this).val());
        });
        let length = $("input[name='jamcb']:checked").length;
        let dataCheck = checked.join(",");
        if (length != 1) {
            Peringatan("Harus pilih satu data!");
        } else {
            Load_Loading();
            $.ajax({
                type: "POST",
                url: "Jamkerja/edit/" + dataCheck,
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

    $("#btn-delete").click(function (e) {
        e.preventDefault();
        /**
         * untuk handle checbox
         */
        let checked = [];
        $("input[name='jamcb']:checked").each(function () {
            checked.push($(this).val());
        });
        let length = $("input[name='jamcb']:checked").length;
        let dataCheck = checked.join(",");
        if (length < 1) {
            Peringatan("Belum ada data yang dipilih");
        } else {
            Swal.fire({
                title: "Hapus Data Jam Kerja?",
                text: "Yakin hapus data jam kerja ?",
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
                        url: "Jamkerja/destroy",
                        data: { [csrfName]: csrfHash, id: dataCheck },
                        success: function (res) {
                            Clear_Loading();
                            Berhasil(res.messages);
                            load();
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
    });
});

function load() {
    table.ajax.reload();
}
