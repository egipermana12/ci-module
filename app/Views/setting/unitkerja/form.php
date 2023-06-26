<div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
  <div class="modal-dialog modal-lg overflow-auto">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $judul; ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?= form_open_multipart('UnitKerja/create', ['id' => 'form']) ?>
    <?= csrf_field(); ?>
    <div class="modal-body">
        <div class="form-floating mb-3">
          <input type="text" name="nm_unit_kerja" id="nm_unit_kerja" value="<?= $nm_unit_kerja; ?>" class="form-control form-control-sm" id="floatingInput" placeholder="Kantor Pusat">
          <label for="floatingInput">Nama Unit Kerja</label>
        </div>
        <div class="form-floating mb-3">
          <input type="number" name="jarak_toleran" id="jarak_toleran" value="<?= $jarak_toleran; ?>" class="form-control form-control-sm" id="floatingInput" placeholder="100">
          <label for="floatingInput">Jarak Toleran (dalam m2)</label>
        </div>
        <div class="form-floating mb-3">
           <textarea class="form-control" placeholder="Leave a comment here" name="alamat" id="alamat" style="height: 100px"><?= esc($alamat); ?></textarea>
            <label for="floatingTextarea2">Alamat Unit Kerja</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" name="koordinat_lokasi" id="koordinat_lokasi" value="<?= $koordinat_lokasi; ?>" class="form-control form-control-sm" id="floatingInput" placeholder="Koordinat Lokasi">
          <label for="floatingInput">Koordinat Lokasi</label>
        </div>
        <div class="form-floating mb-3">
           <textarea class="form-control" placeholder="Leave a comment here" name="koordinat_bidang" id="koordinat_bidang" style="height: 100px"><?= esc($koordinat_bidang); ?></textarea>
            <label for="floatingTextarea2">Koordinat Bidang</label>
        </div>
        <div class="form-floating mb-3">
          <input type="file" name="gambarfile" id="gambarfile" value="<?= $gambar; ?>" class="form-control form-control-sm" id="floatingInput" placeholder="Koordinat Lokasi" accept="image/png, image/jpeg, image/jpg">
          <label for="floatingInput">Gambar Lokasi</label>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="gambarold" value="<?= $gambarold; ?>">
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
            url: "UnitKerja/create",
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
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

</script>
