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

function selectWilayah() {
    $("#kabupaten").html('<option value="">Pilih Kabupaten</option>');

    $("#provinsi").select2({
        dropdownParent: $("#staticBackdrop"),
    });
    $("#kabupaten").select2({
        dropdownParent: $("#staticBackdrop"),
    });

    $("#provinsi").change(function (e) {
        var id_provinsi = $("#provinsi").val();
        var aksi = "getKabKota";
        if (id_provinsi != "") {
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
                    $("#kabupaten").html(
                        '<option value="">Loading...</option>'
                    );
                },
                success: function (data) {
                    var html = '<option value="">Pilih Kabupaten</option>';
                    for (var i = 0; i < data.length; i++) {
                        html +=
                            '<option value="' +
                            data[i].id_kabkota +
                            '">' +
                            data[i].nm_kabkota +
                            "</option>";
                    }
                    $("#kabupaten").html(html);
                },
            });
        } else {
            $("#kabupaten").val("");
            $("#kabupaten").html('<option value="">Pilih Kabupaten</option>');
            $("#kecamatan").val("");
            $("#kecamatan").html('<option value="">Pilih Kecamatan</option>');
            $("#kelurahan").val("");
            $("#kelurahan").html('<option value="">Pilih Kelurahan</option>');
        }
        $("#kecamatan").val("");
    });

    selectKecamatan();
    selectKelurahan();
}

function selectKecamatan() {
    $("#kecamatan").html('<option value="">Pilih Kecamatan</option>');
    $("#kecamatan").select2({
        dropdownParent: $("#staticBackdrop"),
    });
    $("#kabupaten").change(function (e) {
        var id_provinsi = $("#provinsi").val();
        var id_kabupaten = $("#kabupaten").val();
        var aksi = "getKec";
        if (id_kabupaten != "" && id_provinsi != "") {
            $.ajax({
                url: "Pegawai/getWilayah",
                type: "POST",
                data: {
                    [csrfName]: csrfHash,
                    id_kabupaten: id_kabupaten,
                    id_provinsi: id_provinsi,
                    getWilayah: aksi,
                },
                dataType: "JSON",
                beforeSend: function () {
                    $("#kecamatan").html(
                        '<option value="">Loading...</option>'
                    );
                },
                success: function (data) {
                    var html = '<option value="">Pilih Kecamatan</option>';
                    for (var i = 0; i < data.length; i++) {
                        html +=
                            '<option value="' +
                            data[i].id_kecamatan +
                            '">' +
                            data[i].nm_kecamatan +
                            "</option>";
                    }
                    $("#kecamatan").html(html);
                },
            });
        } else {
            $("#kecamatan").val("");
            $("#kecamatan").html('<option value="">Pilih Kecamatan</option>');
            $("#kelurahan").val("");
            $("#kelurahan").html('<option value="">Pilih Kelurahan</option>');
        }
        $("#kelurahan").val("");
    });
}

function selectKelurahan() {
    $("#kelurahan").html('<option value="">Pilih Kelurahan</option>');
    $("#kelurahan").select2({
        dropdownParent: $("#staticBackdrop"),
    });
    $("#kecamatan").change(function (e) {
        var id_kecamatan = $("#kecamatan").val();
        var id_provinsi = $("#provinsi").val();
        var id_kabupaten = $("#kabupaten").val();
        var aksi = "getKel";
        if (id_kecamatan != "") {
            $.ajax({
                url: "Pegawai/getWilayah",
                type: "POST",
                data: {
                    [csrfName]: csrfHash,
                    id_kecamatan: id_kecamatan,
                    id_kabupaten: id_kabupaten,
                    id_provinsi: id_provinsi,
                    getWilayah: aksi,
                },
                dataType: "JSON",
                beforeSend: function () {
                    $("#kelurahan").html(
                        '<option value="">Loading...</option>'
                    );
                },
                success: function (data) {
                    var html = '<option value="">Pilih Kelurahan</option>';
                    for (var i = 0; i < data.length; i++) {
                        html +=
                            '<option value="' +
                            data[i].id_kelurahan +
                            '">' +
                            data[i].nm_kelurahan +
                            "</option>";
                    }
                    $("#kelurahan").html(html);
                },
            });
        } else {
            $("#kelurahan").val("");
            $("#kelurahan").html('<option value="">Pilih Kelurahan</option>');
        }
        $("#kelurahan").val("");
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
