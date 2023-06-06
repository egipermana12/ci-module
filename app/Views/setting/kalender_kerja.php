<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <div class="text-uppercase fs-6 fw-medium">
            kalender kerja
        </div> 
        <div class="py-1">
            <a href="<?=$config->baseURL?>setting/labelkalender" class="btn btn-outline-success btn-sm"><i class="fas fa-plus pe-1"></i> Add Label</a>
            <a href="<?=$config->baseURL?>setting/kalender/addkegiatan" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus pe-1"></i> Add Kegiatan</a>
        </div> 
    </div>
    <div class="card-body">    
    <!-- untuk list label kalender -->
        <div class="d-flex flex-row justify-content-center align-items-center my-3">
            <?php foreach($labelKalender as $val) : ?>
                <div class="d-flex justify-content-center align-items-center mx-2">
                    <span class="label-color" style="background: <?= $val['warna'] ?> "></span>
                    <p class="text-gray text-capitalize text fw-medium px-2"><?= $val['nm_label'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>    
        <!-- untuk list label kalender -->
        <?= $time;  ?>
    </div>
</div>
<?=$this->endSection()?>
