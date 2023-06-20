<div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $judul; ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?= form_open('Kegiatan/create', ['id' => 'formKegiatan']) ?>
    <?= csrf_field(); ?>
    <div class="modal-body">
        <div class="form-floating mb-3">
          <input type="text" name="nm_kegiatan" id="nm_kegiatan" value="<?= $nm_kegiatan; ?>" class="form-control form-control-sm" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Nama Kegiatan</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" name="tgl_kegiatan" id="tgl_kegiatan" value="<?= $tgl_kegiatan; ?>" class="form-control form-control-sm" id="floatingInput" placeholder="DD/MM/YYYY s/d DD/MM/YYYY">
          <label for="floatingInput">Tanggal Kegiatan</label>
        </div>
        <div class="form-floating mb-3">
           <select class="form-select" id="id_kalender_label" name="id_kalender_label" aria-label="Default select example">
              <option value="" selected>Pilih Label</option>
                <?php foreach($label as $val) : ?>
                    <option class="text-capitalize" value="<?= $val['id']; ?>" <?php echo $val['id'] == $id_kalender_label ? 'selected' : '' ?> ><?= $val['nm_label'] ?></option>
                <?php endforeach; ?>
           </select>
          <label for="floatingInput">Pilih Label</label>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="tgl_mulai_kegiatan" value="<?= $tgl_mulai_kegiatan ?>" class="tgl_mulai_kegiatan">
        <input type="hidden" name="tgl_selesai_kegiatan" value="<?= $tgl_selesai_kegiatan ?>" class="tgl_selesai_kegiatan">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
    </div>
    <?= form_close() ?>
</div>
</div>
</div>

<script>
    $('#formKegiatan').on('submit', function(e){
        e.preventDefault();
        Load_Loading();
        $.ajax({
            type: "POST",
            url: "Kegiatan/create",
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
                    console.log(resp);
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

    startDate =  $('.tgl_mulai_kegiatan').val();
    endDate =  $('.tgl_selesai_kegiatan').val();
    if(startDate == 'undefined' && endDate == 'undefined' || startDate == '' && endDate == '')
    {
        startDate = moment();
        endDate = moment();
    }

    //untuk datarange
    $('input[name="tgl_kegiatan"]').daterangepicker({
        "drops": "up",
        "parentEl": $('#staticBackdrop'),
        "showDropdowns": true,
        "autoUpdateInput": false,
        "locale": {
            "format": "YYYY-MM-DD",
            "cancelLabel": 'Clear'
        },
        startDate: startDate,
        endDate: endDate,
    });
    $('input[name="tgl_kegiatan"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' s/d ' + picker.endDate.format('YYYY-MM-DD'));
      var startDate = picker.startDate.format('YYYY-MM-DD');
      var endDate = picker.endDate.format('YYYY-MM-DD');
      $('.tgl_mulai_kegiatan').val(startDate);
      $('.tgl_selesai_kegiatan').val(endDate);
  });
</script>
