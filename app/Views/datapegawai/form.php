<div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
  <div class="modal-dialog modal-xl">
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
                        <img class="image-wrapper" id="previewFoto" alt="" src="<?= base_url("images/pegawai/default.svg"); ?>" />
                        <label for="fotoInput" class="wrapper-profile shadow">
                          <i class="fas fa-solid fa-pen" class="upload-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"></i>
                          <input type="file" name="foto_pegawai" id="fotoInput" accept=".png, .jpg, .jpeg">
                      </label>
                      <label class="wrapper-remove-preview shadow" id="remove-preview">
                        <i class="fas fa-regular fa-xmark" class="remove-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"></i>
                    </label>
                </div>
                <div class="form-text">Allowed file types:  png, jpg, jpeg.</div>
            </div>
            <div class="col-6">
                <h4 class="text-black mb-4">
                    Detail Pegawai
                </h4>
                <div class="mb-3">
                  <label for="nmPegawai" class="form-label fw-medium fs-6 text-light-emphasis">Nama Pegawai <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-lg" name="nm_pegawai" id="nmPegawai" placeholder="Jhon Doe">
              </div>
              <div class="row mb-3">
                <label for="Gender" class="form-label fw-medium fs-6 text-light-emphasis">Gender <span class="text-danger">*</span></label>
                <div class="col-auto">
                    <label class="label-radio">
                        <input type="radio" name="jns_kelamin" value="L" class="card-input-element" checked />
                        <div class="panel panel-default card-input">
                            <div class="panel-body fw-medium fs-7 text-light-emphasis">
                                Laki - Laki
                            </div>
                        </div>
                    </label>
                </div>
                <div class="col-auto">
                    <label class="label-radio">
                        <input type="radio" name="jns_kelamin" value="P" class="card-input-element" />
                        <div class="panel panel-default card-input">
                            <div class="panel-body fs-7 fw-medium text-light-emphasis">
                                Perempuan
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja<span class="text-danger">*</span></label>
                <select class="form-select" name="id_unit_kerja" aria-label="Default select example">
                  <option value="" selected>Pilih Unit Kerja</option>
                  <?php foreach($unitKerja as $val) : ?>
                    <option value="<?= $val['id_unit_kerja']; ?>"><?= $val['nm_unit_kerja'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Divisi Kerja<span class="text-danger">*</span></label>
            <select class="form-select" name="id_divisi" aria-label="Default select example">
              <option value="" selected>Pilih Divisi Kerja</option>
              <?php foreach($divisKerja as $val) : ?>
                <option value="<?= $val['id_divisi_kerja'] ?>"><?= $val['nm_divisi'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
      <label for="alamat" class="form-label fw-medium fs-6 text-light-emphasis">Alamat <span class="text-danger">*</span></label>
      <textarea class="form-control form-control-lg"></textarea>
  </div>
  <div class="mb-3">
    <label for="Provinsi" class="fw-medium fs-6 text-light-emphasis">Pilih Provinsi<span class="text-danger">*</span>
    </label>
    <select class="form-select" data-control="select2" id="provinsi" aria-label="Provinsi">
        <option value="">Pilih Provinsi</option>
        <?php foreach($prov as $val) : ?>
            <option value="<?= $val['id_provinsi'] ?>"><?= $val['nm_provinsi'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Pilih Kabupaten Kota<span class="text-danger">*</span></label>
    <select class="form-select" aria-label="Default select example" id="kabupaten">
  </select>
</div>
<div class="mb-3">
    <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Pilih Kecamatan<span class="text-danger">*</span></label>
    <select class="form-select" aria-label="Default select example" id="kecamatan">
  </select>
</div>
<div class="mb-3">
    <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Pilih Keluarahan<span class="text-danger">*</span></label>
    <select class="form-select" aria-label="Default select example" id="kelurahan">
  </select>
</div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
</div>
<?= form_close() ?>
</div>
</div>
</div>

<script>
    
    selectWilayah();

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
                if(resp.err) {
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
                    load();
                    $('.btn-close').click();
                }
            }
        });
    });

    $('#staticBackdrop').on('hidden.bs.modal', function () {
        $('.modal').remove();
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


</script>
