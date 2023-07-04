<div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
  <div class="modal-dialog modal-lg overflow-auto">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $judul; ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?= form_open('Divisi/create', ['id' => 'form']) ?>
    <?= csrf_field(); ?>
    <div class="modal-body">
        <div class="form-floating mb-3">
          <input type="text" name="nm_shift" id="nm_shift" value="<?= $nm_shift; ?>" class="form-control form-control-sm" id="floatingInput" placeholder="Human Resource">
          <label for="floatingInput">Nama Shift Kerja</label>
        </div>
        <div class="row g-3 align-items-center">
            <div class="form-floating mb-3 col-4">
              <input type="time" name="jam_mulai_kerja" id="jam_mulai_kerja" value="<?= $jam_mulai_kerja; ?>" class="form-control form-control-sm timepickerform" id="floatingInput" placeholder="Human Resource">
              <label for="floatingInput">Jam Mulai</label>
            </div>
            <div class="form-floating mb-3 col-4">
              <input type="time" name="jam_selesai_kerja" id="jam_selesai_kerja" value="<?= $jam_selesai_kerja; ?>" class="form-control form-control-sm timepickerform" id="floatingInput" placeholder="Human Resource">
              <label for="floatingInput">Jam Selesai</label>
            </div>
            <div class="col-auto">
            <span id="passwordHelpInline" class="form-text text-success">
              Format Jam dari 00 sampai 24.
            </span>
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
            url: "Jamkerja/create",
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

    $('input.timepickerform').timepicker();

</script>
