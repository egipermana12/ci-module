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
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 justify-content-start g-2 mx-3 mb-5">
            <?php foreach($labelKalender as $val) : ?>
                <div class="col d-flex align-items-center">
                    <span class="label-color" style="background: <?= $val['warna'] ?> "></span>
                    <p class="text-body-secondary text-capitalize fw-normal px-2"><?= $val['nm_label'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>    
        <!-- untuk list label kalender -->
        <?= $time;  ?>
    </div>
</div>
<?=$this->endSection()?>
