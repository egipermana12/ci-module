<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <div class="text-capitalizefw-medium">
            Data Pegawai
        </div>
        <div class="d-flex text-end gap-2">
            <button id="btn-delete" class="btn btn-sm btn-danger"><i class="fas fa-solid fa-square-xmark"></i> Delete Record</button>
            <button id="btn-edit" class="btn btn-sm btn-success"><i class="fas fa-solid fa-square-minus"></i> Edit Record</button>
            <button id="btn-baru" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-square-plus"></i> New Record</button>
        </div> 
    </div>
    <div class="card-body">
        <div id="loadingSegment"></div> 
        <div id="dataPegawai"></div> 
    </div>
</div>
<div class="tampilModal" style="display: none;"></div>
<?=$this->endSection()?>
