<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$site_title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/bootstrap/css/bootstrap.min.css?r=' . time()?>">
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/fontawesome/css/all.css?r='.time()?>"/>
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/styles.css?r=' . time()?>">


    <?php
    if (@$styles) {
        foreach($styles as $file) {
            echo '<link rel="stylesheet" type="text/css" href="'.$file.'?r='.time().'"/>';
        }
    }
    ?>

    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/jquery/jquery.min.js?r='.time()?>"></script>
    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/bootstrap/js/bootstrap.min.js?r='.time()?>"></script>

    <?php

    if (@$scripts) {
        foreach($scripts as $file) {
            echo '<script type="text/javascript" src="'.$file.'?r='.time().'"/></script>';
        }
    }
    ?>

</head>
<body>
    <section class="row layout__wrapper">
        <?php
            $this->renderSection('content')
        ?>
    </section>
</body>
</html>
