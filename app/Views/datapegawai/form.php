<div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $judul; ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?= form_open('Pegawai/create', ['id' => 'form']) ?>
    <?= csrf_field(); ?>
    <div class="modal-body" style="height: 600px; overflow-y: auto;">
        <div class="container">
            <div class="row mt-3 justify-content-center">
                <div class="col-4 offset-1">
                    <div class="wrapper-upload position-relative d-inline-block shadow-lg">
                        <img class="image-wrapper" id="previewFoto" alt="" src="<?= base_url("images/pegawai/default.svg"); ?>" />
                        <label for="fotoInput" class="wrapper-profile shadow">
                          <i class="fas fa-solid fa-pen" class="upload-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"></i>
                          <input type="file" name="avatar" id="fotoInput" accept=".png, .jpg, .jpeg">
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
                      <input type="text" class="form-control form-control-lg" id="nmPegawai" placeholder="Jhon Doe">
                    </div>
                    <div class="row mb-3">
                        <label for="Gender" class="form-label fw-medium fs-6 text-light-emphasis">Gender <span class="text-danger">*</span></label>
                        <div class="col-auto">
                            <label class="label-radio">
                                <input type="radio" name="jns_kelamin" class="card-input-element" checked />
                                <div class="panel panel-default card-input">
                                    <div class="panel-body fw-medium fs-7 text-light-emphasis">
                                        Laki - Laki
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="label-radio">
                                <input type="radio" name="jns_kelamin" class="card-input-element" />
                                <div class="panel panel-default card-input">
                                    <div class="panel-body fs-7 fw-medium text-light-emphasis">
                                        Perempuan
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unitKerja" class="form-label fw-medium fs-6 text-light-emphasis">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
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
    $('#form').on('submit', function(e){
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "Divisi/create",
            dataType: "JSON",
            data: $(this).serialize(),
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

    $('#fotoInput').change(function(e){
      var reader = new FileReader();
          reader.onload = function() {
            var preview = document.getElementById("previewFoto");
            preview.src = reader.result;
          }
          reader.readAsDataURL(event.target.files[0]);
    });

    const tombol = $('.upload-icon');
    tombol.click(function(){
      document.getElementById("fotoInput").click();
    });


</script>
