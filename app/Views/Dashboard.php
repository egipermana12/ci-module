<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<?php print_r(@$scripts);?>
    <?php print_r(@$styles);?>
    <a class="dropdown-item py-2" href="<?=$config->baseURL?>login/logout">Logout</a>
    
<?=$this->endSection()?>
