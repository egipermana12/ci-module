/**
 * untuk setting datatables
 */
var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader("X-CSRF-Token", csrfHash);
});

var table;

jQuery(document).ready(function () {
    if ($("#data-tables").length > 0) {
        const $setting = $("#dataTables-setting");
        let settings = {};
        if ($setting.length > 0) {
            settings = $.parseJSON($("#dataTables-setting").html());
        }

        const addSettings = {
            buttons: [
                {
                    extend: "collection",
                    text: "<i class='fas fa-duotone fa-download'></i> export",
                    className: "btn-export rounded",
                    buttons: [
                        {
                            text: "Chose on options",
                        },
                        {
                            extend: "copy",
                            text: "<i class='far fa-copy'></i> Copy",
                            className: "btn-success ml-1",
                        },
                        {
                            extend: "excel",
                            title: "Data Label Kalender",
                            text: "<i class='far fa-file-excel'></i> excel",
                            className: "btn-success ml-1",
                            exportOptions: {
                                columns: [1, 2],
                                modifier: { selected: null },
                            },
                        },
                        {
                            extend: "pdf",
                            title: "Data Label Kalender",
                            text: "<i class='far fa-file-pdf'></i> pdf",
                            className: "btn-success ml-1",
                            exportOptions: {
                                columns: [1, 2],
                                modifier: { selected: null },
                            },
                        },
                        {
                            extend: "print",
                            title: "Data Label Kalender",
                            text: "<i class='fas fa-print'></i> print",
                            className: "btn-success",
                            exportOptions: {
                                columns: [1, 2],
                                modifier: { selected: null },
                            },
                        },
                    ],
                },
                {
                    text: "<i class='fas fa-solid fa-file-circle-plus'></i> New Record",
                    className: "btn-export mx-3 rounded",
                    attr: { id: "modalForm" },
                },
                {
                    text: "<i class='fas fa-solid fa-rotate-right'></i> Reload",
                    className: "btn-success mx-3 rounded",
                    attr: { id: "reload" },
                    action: function () {
                        table.ajax.reload();
                    },
                },
            ],
            language: {
                searchPlaceholder: "Cari Data",
                paginate: {
                    next: '<i class="fa-solid fa-chevron-right"></i>', // or '>'
                    previous: '<i class="fa-solid fa-chevron-left"></i>', // or '<'
                },
                loadingRecords: "&nbsp;",
                processing:
                    '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
            },
            dom:
                "<'row align-items-center'<'col-sm-6'B><'col-sm-6'f>>" +
                "<'row'<'col-sm-12't>>" +
                "<'row mt-2 align-items-center'<'col-sm-6 cs-text'i><'col-sm-2 cs-text'l><'col-sm-4'p>>",
            lengthMenu: [10, 25, 50, 75, 100],
            processing: true,
            ajax: {
                url: "LabelKalender/fetchData",
                type: "POST",
                data: { [csrfName]: csrfHash },
                dataType: "JSON",
            },
            deferRender: true,
        };

        // Merge settings
        // settings['lengthChange'] = false;
        settings = { ...settings, ...addSettings };

        // settings['buttons'] = [ 'copy', 'excel', 'pdf', 'colvis' ];
        table = $("#data-tables").DataTable(settings);
        table
            .buttons()
            .container()
            .appendTo("#data-tables_wrapper .col-md-6:eq(1)");

        // No urut
        table
            .on("order.dt search.dt", function () {
                table
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
    }

    /**
     * untuk modal form
     */
    $("#modalForm").click(function (e) {
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "LabelKalender/new",
            data: { [csrfName]: csrfHash },
            success: function (res) {
                Clear_Loading();
                // console.log(res.data);
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
    alert("Hello");
}

function hapus(id) {
    Swal.fire({
        title: "Hapus Data Label?",
        text: "Yakin hapus data label dengan ID : " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus label!",
    }).then((result) => {
        if (result.isConfirmed) {
            Load_Loading();
            $.ajax({
                type: "POST",
                url: "LabelKalender/delete",
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
