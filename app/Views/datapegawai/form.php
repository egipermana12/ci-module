<div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $judul; ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('Pegawai/create', ['id' => 'form']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body" style="height: 500px; overflow-y: auto;">
                <div class="container">
                    <div class="row mt-3 justify-content-center">
                        <div class="col-4 offset-1">
                            <div class="wrapper-upload position-relative d-inline-block shadow-lg">
                                <?php $image="default.svg"; strlen($foto_pegawai) == 0 ? $image : $image = $foto_pegawai ?>
                                <img class="image-wrapper" id="previewFoto" alt="" src="<?= base_url("images/pegawai/" . $image); ?>" />
                                <label for="fotoInput" class="wrapper-profile shadow">
                                    <i class="fas fa-solid fa-pen" class="upload-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"></i>
                                    <input type="file" name="foto_pegawai" id="fotoInput" accept=".png, .jpg, .jpeg">
                                </label>
                                <label class="wrapper-remove-preview shadow" id="remove-preview">
                                    <i class="fas fa-regular fa-xmark" class="remove-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"></i>
                                </label>
                            </div>
                            <div class="form-text">Allowed file types:  png, jpg, jpeg.</div>
                            <div class="mt-3 row justify-content-center align-items-end">
                                <div class="col-8">
                                    <div class="mt-3">
                                        <label for="nik" class="form-label fw-medium fs-6 text-light-emphasis">NIK <span class="text-danger form-text">(Nomor Induk Karyawan)</span></label>
                                        <input type="text" class="form-control form-control-lg" name="nik" id="nik" value="<?= $nik; ?>" placeholder="">
                                    </div>
                                </div>
                                <?php if($id == "") { ?>
                                    <div class="col-4">
                                        <button type="button" id="generateNIK" class="btn btn-success"><i class="fas fa-solid fa-rotate"></i></button>
                                    </div>
                                <?php }else { ?>
                                    <div class="col-4"></div>
                                <?php } ?>
                            </div>
                            <div class="form-text">tekan tombol untuk generate NIK otomatis</div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-black mb-4">
                                Detail Pegawai
                            </h4>
                            <div class="mb-3">
                                <label for="nm_pegawai" class="form-label fw-medium fs-6 text-light-emphasis">Nama Pegawai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="nm_pegawai" value="<?= $nm_pegawai; ?>" id="nm_pegawai" placeholder="Jhon Doe">
                            </div>
                            <div class="row mb-3">
                                <label for="Gender" class="form-label fw-medium fs-6 text-light-emphasis">Gender <span class="text-danger">*</span></label>
                                <div class="col-auto">
                                    <label class="label-radio">
                                        <input type="radio" id="jns_kelamin" name="jns_kelamin" value="L" <?= $jns_kelamin == "L" ? 'checked="checked"' : '' ?> class="card-input-element" checked />
                                        <div class="panel panel-default card-input">
                                            <div class="panel-body fw-medium fs-7 text-light-emphasis">
                                                Laki - Laki
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-auto">
                                    <label class="label-radio">
                                        <input type="radio" id="jns_kelamin" name="jns_kelamin" value="P" <?= $jns_kelamin == "P" ? 'checked="checked"' : '' ?> class="card-input-element" />
                                        <div class="panel panel-default card-input">
                                            <div class="panel-body fs-7 fw-medium text-light-emphasis">
                                                Perempuan
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tglLahir" class="form-label fw-medium fs-6 text-light-emphasis">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="tgl_lahir" value="<?= $tgl_lahir; ?>" placeholder="1992-12-12" id="tgl_lahir">
                            </div>
                            <div class="mb-3">
                                <label for="tglLahir" class="form-label fw-medium fs-6 text-light-emphasis">Tanggal Bergabung <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="tgl_bergabung" placeholder="2023-12-12" value="<?= $tgl_bergabung; ?>" id="tgl_bergabung">
                            </div>
                            <div class="mb-3">
                                <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja<span class="text-danger">*</span></label>
                                <select class="form-select" name="id_unit_kerja" id="id_unit_kerja" aria-label="Default select example">
                                    <option value="" selected>Pilih Unit Kerja</option>
                                    <?php foreach($unitKerja as $val) : ?>
                                        <?php $selected = ($id_unit_kerja == $val['id_unit_kerja']) ? 'selected' : ''; ?>
                                        <option <?= $selected; ?> value="<?= $val['id_unit_kerja']; ?>" ><?= $val['nm_unit_kerja'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Divisi Kerja<span class="text-danger">*</span></label>
                                <select class="form-select" name="id_divisi" id="id_divisi" aria-label="Default select example">
                                    <option value="" selected>Pilih Divisi Kerja</option>
                                    <?php foreach($divisKerja as $val) : ?>
                                        <?php $selected = ($id_divisi == $val['id_divisi_kerja']) ? 'selected' : ''; ?>
                                        <option <?= $selected; ?> value="<?= $val['id_divisi_kerja'] ?>"><?= $val['nm_divisi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-medium fs-6 text-light-emphasis">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg" name="alamat"><?= $alamat; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="Provinsi" class="fw-medium fs-6 text-light-emphasis">Pilih Provinsi<span class="text-danger">*</span>
                                </label>
                                <select class="form-select" data-control="select2" name="kd_prov" id="provinsi" aria-label="Provinsi">
                                    <option value="">Pilih Provinsi</option>
                                    <?php foreach($prov as $val) : ?>
                                        <?php $selected = ($kd_prov == $val['id_provinsi']) ? 'selected' : ''; ?>
                                        <option <?= $selected; ?> value="<?= $val['id_provinsi'] ?>"><?= $val['nm_provinsi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Pilih Kabupaten Kota<span class="text-danger">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="kd_kab_kota" id="kabupaten">
                                    <option value="">Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Pilih Kecamatan<span class="text-danger">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="kd_kec" id="kecamatan">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Pilih Keluarahan<span class="text-danger">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="kd_kel" id="kelurahan">
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <input type="hidden" id="kd_prov" value="<?= $kd_prov; ?>">
                <input type="hidden" id="kd_kab_kota" value="<?= $kd_kab_kota; ?>">
                <input type="hidden" id="kd_kec" value="<?= $kd_kec; ?>">
                <input type="hidden" id="kd_kel" value="<?= $kd_kel; ?>">
                <input type="hidden" name="foto_pegawai_old" id="foto_pegawai_old" value="<?= $foto_pegawai_old; ?>">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $("#provinsi").change(function (e) {
        var id_provinsi = $("#provinsi").val();
        if (id_provinsi != "") {
            selectKabupaten(id_provinsi);
        } else {
            $("#kabupaten").val("");
            $("#kabupaten").html('<option value="">Pilih Kabupaten</option>');
        }
        $("#kecamatan").val("");
        $("#kecamatan").html('<option value="">Pilih Kecamatan</option>');
        $("#kelurahan").val("");
        $("#kelurahan").html('<option value="">Pilih Kelurahan</option>');
    });
    $("#kabupaten").change(function (e) {
        var id_provinsi = $("#provinsi").val();
        var id_kabupaten = $("#kabupaten").val();
        if (id_provinsi != "" && id_kabupaten != "") {
            selectKecamatan(id_provinsi, id_kabupaten);
        } else {
            $("#kecamatan").val("");
            $("#kecamatan").html('<option value="">Pilih Kecamatan</option>');
        }
        $("#kelurahan").val("");
        $("#kelurahan").html('<option value="">Pilih Kelurahan</option>');
    });
    $("#kecamatan").change(function (e) {
        var id_provinsi = $("#provinsi").val();
        var id_kabupaten = $("#kabupaten").val();
        var id_kecamatan = $("#kecamatan").val();
        if (id_provinsi != "" && id_kabupaten != "" && id_kecamatan != "") {
            selectKelurahan(id_provinsi, id_kabupaten, id_kecamatan);
        } else {
            $("#kelurahan").val("");
            $("#kelurahan").html('<option value="">Pilih Kelurahan</option>');
        }
    });
    var edit = $('#id').val();
    if(edit != ""){
        var id_provinsi_edit = $("#kd_prov").val();
        var id_kabupaten_edit = $("#kd_kab_kota").val();
        var id_kec_edit = $("#kd_kec").val();
        var id_kel_edit = $("#kd_kel").val();
        selectKabupaten(id_provinsi_edit, id_kabupaten_edit);
        selectKecamatan(id_provinsi_edit, id_kabupaten_edit, id_kec_edit);
        selectKelurahan(id_provinsi_edit, id_kabupaten_edit, id_kec_edit, id_kel_edit);
    }
    $('#form').on('submit', function(e){
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "Pegawai/create",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            dataType: "JSON",
            beforeSend: function() {
                $('#btn-simpan').attr('disabled', 'disabled');
                $('#btn-simpan').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>saving...');
            },
            complete: function() {
                $('#btn-simpan').removeAttr('disabled');
                $('#btn-simpan').html('Simpan');
            },
            success: function(resp) {
                if(resp.success === false) {
                    Clear_Loading();
                    let errors = resp.messages;
                    for(const error in errors){
                        $('#' + `${error}`).removeClass('is-invalid');
                        $('#' + `${error}`).next('.invalid-feedback').remove();
                        Peringatan(`${errors[error]}`);
                        $('#' + `${error}`).addClass('is-invalid');
                        $('<div id="validationServerUsernameFeedback" class="invalid-feedback">' + errors[error] + '</div>').insertAfter('#' + `${error}`);
                    }
                }else{
                    Clear_Loading();
                    Berhasil(resp.messages);
                    tampilTable();
                    $('.btn-close').click();
                }
            }
        });
    });
    $('#staticBackdrop').on('hidden.bs.modal', function () {
        $('.modal').remove();
    });
// csrf untuk generate NIK
var csrfName = $("meta.csrf").attr("name"); //CSRF TOKEN NAME
var csrfHash = $("meta.csrf").attr("content"); //CSRF HASH
/**
* generate NIK
*/
$('#generateNIK').click(function(e){
    e.preventDefault();
    let thn_gabung = $('#tgl_bergabung').val();
    let unitkerja = $('#id_unit_kerja').val();
    let divisKerja = $('#id_divisi').val();
    if(thn_gabung == '' || unitkerja == '' || divisKerja == ''){
        Peringatan('tanggal bergabung, unit kerja atau divis kerja masih kosong');
    }else{
        $.ajax({
            type: "POST",
            url: "Pegawai/generateNIK",
            data: { [csrfName]: csrfHash, thn_gabung: thn_gabung, unitkerja: unitkerja, divisKerja: divisKerja},
            dataType: "JSON",
            beforeSend: function() {
                $('#generateNIK').attr('disabled', 'disabled');
                $('#generateNIK').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
            },
            complete: function() {
                $('#generateNIK').removeAttr('disabled');
                $('#generateNIK').html('<i class="fas fa-solid fa-rotate">');
            },
            success: function(resp) {
                if(resp.success){
                    $('#nik').val(resp.hasil);
                }
            }
        });
    }
});
/**
* start upload image previw
*/
var imgDefault = '<?= base_url("images/pegawai/default.svg"); ?>';
$('#remove-preview').hide();
function previewImage(file)
{
    let reader = new FileReader();
    reader.onload = function(e) {
        $('#previewFoto').attr('src', e.target.result);
    }
    reader.readAsDataURL(file);
}
$('#fotoInput').change(function(){
    const file = this.files[0];
    if(file){
        previewImage(file);
        $('#remove-preview').show();
    }else{
        $('#previewFoto').attr('src', imgDefault);
        $('#remove-preview').hide();
    }
});
$('#remove-preview').click(function(){
    $('#previewFoto').attr('src', imgDefault);
    $('#remove-preview').hide();
// Reset input file
    $('#fotoInput').val('');
});
$('.upload-icon').click(function(){
    $('#fotoInput').click();
});
$('#tgl_lahir').datepicker({
    changeYear: true,
    changeMonth: true,
    yearRange: "1985:2025",
    dateFormat: "yy-mm-dd"
});
$('#tgl_bergabung').datepicker({
    changeYear: true,
    changeMonth: true,
    yearRange: "2000:2030",
    dateFormat: "yy-mm-dd"
});
</script>
