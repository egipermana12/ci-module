<?php
$unitkerja = '';
foreach($unitKerja as $val){
    $unitkerja .= "<option value = " .$val['id_unit_kerja'] .">" .$val['nm_unit_kerja'] . "</option>";
}
$divisikerja = '';
foreach($divisKerja as $val){
    $divisikerja .= "<option value = " .$val['id_divisi_kerja'] .">" .$val['nm_divisi'] . "</option>";
}

$html = array();

$html[] = '<div class="table-responsive px-3">';
$html[] = '<div class="row"><div class="col-6"><select id="selectUnitKerja" name="id_uni_kerja" class="form-control form-select form-select-sm mb-3" aria-label="example"><option value="" selected>Pilih Unit Kerja</option>'.$unitkerja.'</select></div><div class="col-6"><select id="selectDivisiKerja" name="id_divisi" class="form-control form-select form-select-sm mb-3" aria-label="example"><option value="" selected>Pilih Divisi Kerja</option>'.$divisikerja.'</select></div></div>';
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
        $("#selectUnitKerja").change(function (event) {
            table.ajax.reload();
            });
            $("#selectDivisiKerja").change(function (event) {
                table.ajax.reload();
                });
                </script>';
                $content = implode('', $html);
                $err = "";
                echo json_encode(array("content" => $content, "err" => $err));
