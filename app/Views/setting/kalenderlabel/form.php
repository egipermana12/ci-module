 <div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $judul; ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?= form_open('labelkalender/create', ['id' => 'formLabelKalender']) ?>
    <?= csrf_field(); ?>
    <div class="modal-body">
        <div class="form-row mb-3">
            <label for="labelName" class="form-label">Nama Label</label>
            <input type="text" name="nm_label" class="form-control" id="nm_label" value="<?= $nm_label; ?>" placeholder="Hari Besar...">
        </div>
        <div class="form-row mb-3">
            <label for="exampleColorInput" class="form-label">Warna Label</label>
            <input type="color" name="warna" class="form-control" id="warna" value="<?= $warna; ?>" title="Choose your color">
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
    $('#formLabelKalender').on('submit', function(e){
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "LabelKalender/create",
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
                    Berhasil('Data disimpan');
                    load();
                    $('.btn-close').click();
                }
            }
        });
    });

    $('#staticBackdrop').on('hidden.bs.modal', function () {
        $('.modal').remove();
    });    
</script>
