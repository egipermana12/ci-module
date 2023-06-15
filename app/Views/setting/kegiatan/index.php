<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <div class="text-capitalizefw-medium">
            kegiatan Kerja
        </div> 
    </div>
    <div class="row align-items-center mx-4 mt-3 p-2 rounded border rounded border-gray">
        <div class="col-6">
            <div class="row align-items-center">    
                <label for="selectLabel" class="col-sm-3">Label Kegiatan:
                </label>
                <div class="col-sm-9">
                    <select id="selectLabel" name="id_label" class="form-control form-select form-select-sm" aria-label=".form-select-sm example">
                      <option value="" selected>Pilih Kategori</option>
                      <?php foreach($labelkagegori as $val) : ?>
                        <option class="text-capitalize" value="<?= $val['id']; ?>"><?= $val['nm_label'] ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    <div class="col-6 text-end">
        <button id="btn-baru" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-square-plus"></i> New Record</button>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive px-3">
        <table class="table table-striped table-bordered table-hover" id="data-tables">
            <thead>
                <tr>
                    <th class="text-center" width="10%">No</th>
                    <th class="text-center" width="20%">Tanggal Mulai</th>
                    <th class="text-center" width="20%">Tanggal Selesai</th>
                    <th class="text-center" width="50%">Nama Kegiatan</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>


<div class="tampilModal" style="display: none;"></div>
<?=$this->endSection()?>
