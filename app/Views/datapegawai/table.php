<?php
$html = array();
$html[] = '<div class="table-responsive px-3">';
$html[] = '<div class="col-sm-9"><select id="selectLabel" name="id_label" class="form-control form-select form-select-sm" aria-label=".form-select-sm example"><option value="" selected>Pilih Kategori</option><option value="7">7</option><option value="8">7</option></select></div>';
$html[] ='<table class="table table-striped table-bordered table-hover" id="data-tables">';
$html[] ='<thead><tr><th class="text-center" width="5%">No</th><th class="text-center" width="3%"><input class="form-check-input cb-custom" type="checkbox" name="selectAll[]" id="selectAll"></th><th class="text-center" width="20%">Nama Pegawai</th><th class="text-center" width="15%">Alamat</th><th class="text-center" width="8%">Gender</th><th class="text-center" width="8%">Divisi Kerja</th><th class="text-center" width="10%">Unit Kerja</th></thead>';
$html[] = '<tbody></tbody>';
$html[] = '</table>';
$html[] ='</div>';

$html[] ='<script>
            tampilData();
            $("#selectAll").click(function (e) {
                if ($(this).is(":checked")) {
                    $(".pegawaicb").prop("checked", true);
                } else {
                    $(".pegawaicb").prop("checked", false);
                }
            });
            $("#selectLabel").change(function (event) {
                table.ajax.reload();
            });
        </script>';
$content = implode('', $html);
$err = "";
echo json_encode(array("content" => $content, "err" => $err));
