<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title text-danger">
            <?php if(empty($title)) {echo 'Error';}else{echo $title;} ?>
        </h5>
    </div>
    <div class="card-body">
        <p class="text-danger">
            <?= $msg; ?>
        </p>
    </div>
</div>
<?=$this->endSection()?>
