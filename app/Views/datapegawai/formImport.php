<div class="modal fade shadow" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $judul; ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('', ['id' => 'formImport']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body" style="height: 200px; overflow-y: auto;">
                <div class="mb-3">
                    <label for="nm_pegawai" class="form-label fw-medium fs-6 text-light-emphasis">Cari Berkas <span class="text-danger">*</span></label>
                    <input type="file" class="form-control form-control-lg" name="file_excel_pegawai" id="file_excel_pegawai" placeholder="Cari Berkas">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    
    $('#formImport').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "Pegawai/importAction",
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
            success: function(resp){
                addBtnView();
            }
        });
    });
    $('#staticBackdrop').on('hidden.bs.modal', function () {
        $('.modal').remove();
    });

    addBtnView = function() {
        $('.modal-footer').append('<button type="button" id="btn-viewdata" class="btn btn-success">Lihat Data</button>');
        $('#btn-simpan').remove();
    }

</script>
