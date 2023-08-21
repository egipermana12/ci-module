<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <div class="text-capitalizefw-medium">
            Data Pegawai
        </div>
        <div class="d-flex text-end gap-2">
            <button id="btn-import" class="btn btn-info text-white"><i class="fas fa-solid fa-cloud-arrow-up"></i> Import</button>
            <button id="btn-delete" class="btn btn-danger"><i class="fas fa-solid fa-trash"></i> Delete</button>
            <button id="btn-edit" class="btn btn-success"><i class="fas fa-solid fa-file-pen"></i> Edit</button>
            <button id="btn-baru" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> New</button>
        </div> 
    </div>
    <div class="card-body">
        <div id="loadingSegment"></div> 
        <div id="dataPegawai"></div> 
    </div>
    
</div>
<div class="tampilModal" style="display: none;"></div>
<?=$this->endSection()?>
