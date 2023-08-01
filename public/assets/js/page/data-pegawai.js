var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH

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
    id_kel_selected = ""
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
                            thrownError
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
                                    thrownError
                            );
                        },
                    });
                }
            });
        }
    });
});
