<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <div class="text-capitalizefw-medium">
            Jam Kerja
        </div>
        <div class="d-flex text-end gap-2">
            <button id="btn-delete" class="btn btn-sm btn-danger"><i class="fas fa-solid fa-square-xmark"></i> Delete Record</button>
            <button id="btn-edit" class="btn btn-sm btn-success"><i class="fas fa-solid fa-square-minus"></i> Edit Record</button>
            <button id="btn-baru" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-square-plus"></i> New Record</button>
        </div> 
    </div>
    <div class="card-body">
        <div class="table-responsive px-3">
            <table class="table table-striped table-bordered table-hover" id="data-tables">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="3%">
                            <input class="form-check-input cb-custom" type="checkbox" name="selectAll[]" id="selectAll">
                        </th>
                        <th class="text-center" width="40%">Nama Shift</th>
                        <th class="text-center" width="10%">Jam Masuk</th>
                        <th class="text-center" width="10%">Jam Keluar</th>
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
