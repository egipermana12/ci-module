var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH

var image_logo =
    "data:image/png;base64,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";

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

function selectKabupaten(id_provinsi, id_kab_selected = "") {
    $("#kabupaten").select2({
        dropdownParent: $("#staticBackdrop"),
    });
    var aksi = "getKabKota";
    $.ajax({
        url: "Pegawai/getWilayah",
        type: "POST",
        data: {
            [csrfName]: csrfHash,
            id_provinsi: id_provinsi,
            getWilayah: aksi,
        },
        dataType: "JSON",
        beforeSend: function () {
            $("#kabupaten").html('<option value="">Loading...</option>');
        },
        success: function (data) {
            var html = '<option value="">Pilih Kabupaten</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id_kabkota + '"';

                if (data[i].id_kabkota === id_kab_selected) {
                    html += " selected";
                }

                html += ">" + data[i].nm_kabkota + "</option>";
            }
            $("#kabupaten").html(html);
        },
    });
}

function selectKecamatan(id_provinsi, id_kabupaten, id_kec_selected = "") {
    $("#kecamatan").select2({
        dropdownParent: $("#staticBackdrop"),
    });
    var aksi = "getKec";
    $.ajax({
        url: "Pegawai/getWilayah",
        type: "POST",
        data: {
            [csrfName]: csrfHash,
            id_provinsi: id_provinsi,
            id_kabupaten: id_kabupaten,
            getWilayah: aksi,
        },
        dataType: "JSON",
        beforeSend: function () {
            $("#kecamatan").html('<option value="">Loading...</option>');
        },
        success: function (data) {
            var html = '<option value="">Pilih Kecamatan</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id_kecamatan + '"';

                if (data[i].id_kecamatan === id_kec_selected) {
                    html += " selected";
                }

                html += ">" + data[i].nm_kecamatan + "</option>";
            }
            $("#kecamatan").html(html);
        },
    });
}

function selectKelurahan(
    id_provinsi,
    id_kabupaten,
    id_kecamatan,
    id_kel_selected = "",
) {
    $("#kelurahan").select2({
        dropdownParent: $("#staticBackdrop"),
    });
    var aksi = "getKel";
    $.ajax({
        url: "Pegawai/getWilayah",
        type: "POST",
        data: {
            [csrfName]: csrfHash,
            id_provinsi: id_provinsi,
            id_kabupaten: id_kabupaten,
            id_kecamatan: id_kecamatan,
            getWilayah: aksi,
        },
        dataType: "JSON",
        beforeSend: function () {
            $("#kelurahan").html('<option value="">Loading...</option>');
        },
        success: function (data) {
            var html = '<option value="">Pilih Kelurahan</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id_kelurahan + '"';

                if (data[i].id_kelurahan === id_kel_selected) {
                    html += " selected";
                }

                html += ">" + data[i].nm_kelurahan + "</option>";
            }
            $("#kelurahan").html(html);
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
                d.id_uni_kerja = $("#selectUnitKerja").val();
                d.id_divisi = $("#selectDivisiKerja").val();
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
            "<'row align-items-center'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12't>>" +
            "<'row mt-2 align-items-center'<'col-sm-4 d-flex justify-content-start align-items-center gap-2'li><'col-sm-8'p>>" +
            "<'row'<'col-sm-12 text-center'<'loading-indicator'>r>>",
        buttons: [
            {
                extend: "collection",
                text: "Export",
                className: "btn-custom",
                buttons: [
                    {
                        extend: "pdfHtml5",
                        title: " ",
                        text: "<i class='far fa-file-pdf'></i> pdf",
                        filename: "Pegawai Report",
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6],
                        },
                        footer: true,
                        orientation: "landscape", //portrait
                        pageSize: "A4", //A3 , A5 , A6 , legal , letter
                        customize: function (doc) {
                            pdfCustom(doc);
                        },
                        message: function () {
                            return (
                                "Company Name : Adul Somad" +
                                "\n Survey Name : Somadi Somad"
                            );
                        },
                    },
                    {
                        extend: "excelHtml5",
                        text: "<i class='far fa-file-xlsx'></i> Excel",
                        className: "btn btn-success btn-sm",
                        filename: "Survey Report",
                        title: "",
                        footer: true,
                        customize: function (xlsx) {
                            customXLSX(xlsx);
                        },
                    },
                ],
            },
        ],
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
                    xhr.status + "\n" + xhr.responseText + "\n" + thrownError,
                );
            },
        });
    });

    $("#btn-edit").click(function (e) {
        e.preventDefault();
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
                            thrownError,
                    );
                },
            });
        }
    });

    $("#btn-delete").click(function (e) {
        e.preventDefault();
        let checked = [];
        $("input[name='pegawaicb']:checked").each(function () {
            checked.push($(this).val());
        });
        let length = $("input[name='pegawaicb']:checked").length;
        let dataCheck = checked.join(",");
        if (length < 1) {
            Peringatan("Belum ada data yang dipilih");
        } else {
            Swal.fire({
                title: "Hapus Data Pegawai?",
                text: "Yakin hapus data pegawai ?",
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
                        url: "Pegawai/destroy",
                        data: { [csrfName]: csrfHash, id: dataCheck },
                        success: function (res) {
                            Clear_Loading();
                            Berhasil(res.messages);
                            tampilTable();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(
                                xhr.status +
                                    "\n" +
                                    xhr.responseText +
                                    "\n" +
                                    thrownError,
                            );
                        },
                    });
                }
            });
        }
    });
});

function pdfCustom(doc) {
    var now = new Date();
    var jsDate =
        now.getDate() + "-" + (now.getMonth() + 1) + "-" + now.getFullYear();
    doc.content.splice(1, 0, {
        width: 80,
        height: 60,
        alignment: "left",
        image: image_logo,
    });
    var objLayout = {};
    objLayout["hLineWidth"] = function (i) {
        return 0.5;
    };
    objLayout["vLineWidth"] = function (i) {
        return 0.5;
    };
    objLayout["hLineColor"] = function (i) {
        return "#aaa";
    };
    objLayout["vLineColor"] = function (i) {
        return "#aaa";
    };
    objLayout["paddingLeft"] = function (i) {
        return 4;
    };
    objLayout["paddingRight"] = function (i) {
        return 4;
    };
    doc.content[3].layout = objLayout;
    doc.content[3].table.widths = [
        [8, 8, 8],
        [300, 300, 300],
        [400, 400, 400],
        [40, 40, 40],
        [200, 200, 200],
        [200, 200, 200],
    ];
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
        fillColor: "#AEAEAE",
        color: "#ffffff",
    };

    doc["header"] = function () {
        return {
            columns: [
                {
                    alignment: "left",
                    italics: true,
                    text: "Data Pegawai",
                    fontSize: 9,
                    margin: [10, 0],
                },
                {
                    alignment: "right",
                    fontSize: 9,
                    text: "Custom PDF export with dataTables",
                },
            ],
            margin: 20,
        };
    };

    doc["footer"] = function (page, pages) {
        return {
            columns: [
                {
                    alignment: "left",
                    text: ["Created on: ", { text: jsDate.toString() }],
                },
                {
                    alignment: "right",
                    text: [
                        "page ",
                        { text: page.toString() },
                        " of ",
                        { text: pages.toString() },
                    ],
                },
            ],
            margin: 20,
        };
    };
}

function customXLSX(xlsx) {
    var sheet = xlsx.xl.worksheets["sheet1.xml"];
    var downrows = 6; //number of rows for heading
    var clRow = $("row", sheet);

    $('row c[r^="A"]', sheet).attr("s", "51");
    $('row c[r^="B"]', sheet).attr("s", "50");
    $('row c[r^="C"]', sheet).attr("s", "51");
    $('row c[r^="D"]', sheet).attr("s", "51");
    $('row c[r^="E"]', sheet).attr("s", "51");
    $('row c[r^="F"]', sheet).attr("s", "51");
    $('row c[r^="G"]', sheet).attr("s", "51");
    $('row c[r^="H"]', sheet).attr("s", "51");

    $("row:first c", sheet).attr("s", "2");
    $("row:last c", sheet).attr("s", "2");

    //update Row
    clRow.each(function () {
        var attr = $(this).attr("r");
        var ind = parseInt(attr);
        ind = ind + downrows;
        $(this).attr("r", ind);
    });

    // Update  row > c
    $("row c ", sheet).each(function () {
        var attr = $(this).attr("r");
        var pre = attr.substring(0, 1);
        var ind = parseInt(attr.substring(1, attr.length));
        ind = ind + downrows;
        $(this).attr("r", pre + ind);
    });

    function Addrow(index, data) {
        var row = sheet.createElement("row");
        row.setAttribute("r", index);
        for (i = 0; i < data.length; i++) {
            var key = data[i].key;
            var value = data[i].value;

            var c = sheet.createElement("c");
            c.setAttribute("t", "inlineStr");
            c.setAttribute("r", key + index);

            var is = sheet.createElement("is");
            var t = sheet.createElement("t");
            var text = sheet.createTextNode(value);

            t.appendChild(text);
            is.appendChild(t);
            c.appendChild(is);

            row.appendChild(c);
        }

        return row;
    }

    var r1 = Addrow(1, [
        {
            key: "A",
            value: "Company Name: " + "cmp_name",
        },
    ]);
    var r2 = Addrow(2, [
        {
            key: "A",
            value: "Survey Name: " + "survey_name",
        },
    ]);
    var r3 = Addrow(3, [
        {
            key: "A",
            value: "Month and Year  : " + "date",
        },
    ]);
    var r4 = Addrow(4, [
        {
            key: "A",
            value: "vendor_category",
        },
    ]);
    var r5 = Addrow(5, [
        {
            key: "A",
            value: "no_of_res_ven",
        },
    ]);

    var sheetData = sheet.getElementsByTagName("sheetData")[0];
    sheetData.insertBefore(r5, sheetData.childNodes[0]);
    sheetData.insertBefore(r4, sheetData.childNodes[0]);
    sheetData.insertBefore(r3, sheetData.childNodes[0]);
    sheetData.insertBefore(r2, sheetData.childNodes[0]);
    sheetData.insertBefore(r1, sheetData.childNodes[0]);
}
