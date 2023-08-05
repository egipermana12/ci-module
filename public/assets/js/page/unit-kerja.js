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
            url: "UnitKerja/fetchData",
        },
        order: [],
        columns: [
            { data: "no", className: "text-center", orderable: false },
            { data: "aksi", className: "text-center", orderable: false },
            { data: "nm_unit_kerja" },
            { data: "alamat" },
            { data: "jarak_toleran", className: "text-end" },
            { data: "koordinat_lokasi" },
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
            "<'row align-items-center'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12't>>" +
            "<'row mt-2 align-items-center'<'col-sm-4 d-flex justify-content-start align-items-center gap-2'li><'col-sm-8'p>>" +
            "<'row'<'col-sm-12 text-center'<'loading-indicator'>r>>",
        buttons: [
            {
                extend: "excelHtml5",
                title: "Data Pegawai Excel",
                text: "<i class='far fa-file-excel'></i> excel",
                exportOptions: {
                    columns: [0, 2, 3, 4, 5, 6],
                },
                customizeData: function (data) {
                    // Memodifikasi data sebelum ekspor
                    var sheet = data.xl.worksheets["sheet1.xml"];

                    // Mengisi cell A1 dan A2 dengan teks
                    var cellA1 =
                        '<c r="A1" t="inlineStr"><is><t>Nama</t></is></c>';
                    var cellA2 =
                        '<c r="A2" t="inlineStr"><is><t>Tgl Lahir</t></is></c>';
                    $("sheetData row:first", sheet).prepend(cellA1);
                    $("sheetData row:eq(1)", sheet).prepend(cellA2);

                    // Mengisi cell A4 dan seterusnya dengan data
                    var rows = $("sheetData row", sheet);
                    rows.each(function (index) {
                        if (index >= 3) {
                            // Mulai dari baris ke-4
                            var rowData = data.body[index - 3];
                            var cellData = rowData
                                .map(function (cell) {
                                    return (
                                        '<c t="inlineStr"><is><t>' +
                                        cell +
                                        "</t></is></c>"
                                    );
                                })
                                .join("");
                            $(this).prepend(cellData);
                        }
                    });
                },
            },
            {
                extend: "pdf",
                title: "Data Pegawai",
                text: "<i class='far fa-file-pdf'></i> pdf",
                filename: "Pegawai Report",
                footer: true,
                message: function () {
                    return (
                        "Company Name : Adul Somad" +
                        "\n Survey Name : Somadi Somad" +
                        "\n"
                    );
                },
                customize: function (doc) {
                    // doc.content.splice(1, 0, {
                    //     width: 80,
                    //     height: 60,
                    //     alignment: "left",
                    //     // image: encode_logo,
                    // });

                    doc.styles.tableBodyEven = {
                        alignment: "center",
                    };
                    doc.styles.tableBodyOdd = {
                        alignment: "center",
                    };
                    doc.styles.tableFooter = {
                        alignment: "center",
                        fillColor: "#2d4154",
                        color: "#ffffff",
                    };
                    doc.styles.tableHeader = {
                        alignment: "center",
                        fillColor: "#2d4154",
                        color: "#ffffff",
                    };
                },
            },
        ],
    });

    $("#selectAll").click(function (e) {
        if ($(this).is(":checked")) {
            $(".unitkerjacb").prop("checked", true);
        } else {
            $(".unitkerjacb").prop("checked", false);
        }
    });

    $("#btn-baru").click(function (e) {
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "UnitKerja/new",
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
        $("input[name='unitkerjacb']:checked").each(function () {
            checked.push($(this).val());
        });
        let length = $("input[name='unitkerjacb']:checked").length;
        let dataCheck = checked.join(",");
        if (length != 1) {
            Peringatan("Harus pilih satu data!");
        } else {
            Load_Loading();
            $.ajax({
                type: "POST",
                url: "UnitKerja/edit/" + dataCheck,
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
        $("input[name='unitkerjacb']:checked").each(function () {
            checked.push($(this).val());
        });
        let length = $("input[name='unitkerjacb']:checked").length;
        let dataCheck = checked.join(",");
        if (length < 1) {
            Peringatan("Belum ada data yang dipilih");
        } else {
            Swal.fire({
                title: "Hapus Data Kegiatan?",
                text: "Yakin hapus data unit kerja ?",
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
                        url: "UnitKerja/destroy",
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
