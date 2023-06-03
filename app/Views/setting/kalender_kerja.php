<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<p class="d-flex flex-column justify-content-center align-items-center py-5">kalender kerja</p>
<!-- untuk list label kalender -->
    <div class="d-flex flex-row justify-content-center align-items-center py-4">
        <?php foreach($labelKalender as $val) : ?>
            <div class="d-flex justify-content-center align-items-center mx-2">
                <span class="label-color" style="background: <?= $val['warna'] ?> "></span>
                <p class="text-gray text-capitalize text fw-medium px-2"><?= $val['nm_label'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>    
<!-- untuk list label kalender -->
<?= $time;  ?>
<?=$this->endSection()?>
