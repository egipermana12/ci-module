<?php 
/**
*   App Name    : Admin Template Dashboard Codeigniter 4
*   Developed by: Agus Prawoto Hadi
*   Website     : https://jagowebdev.com
*   Year        : 2020-2022
*/

if (empty($_SESSION['user'])) {
    $content = 'Layout halaman ini memerlukan login';
    include ('app/Views/app_error.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$site_title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/bootstrap/css/bootstrap.min.css?r=' . time()?>">
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/fontawesome/css/all.css?r='.time()?>"/>
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/bootstrap-icons/bootstrap-icons.css?r='.time()?>"/>
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/styles.css?r=' . time()?>">
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/dashboard.css?r=' . time()?>">
    <?php
        if (@$styles) {
            foreach($styles as $file) {
                if (is_array($file)) {
                    $attr = '';
                    if (key_exists('attr', $file)) {
                        foreach($file['attr'] as $param => $val) {
                            $attr .= $param . '="' . $val . '"';
                        }
                    }
                    $file = $file['url'];
                    echo '<link rel="stylesheet" ' . $attr . ' type="text/css" href="'.$file.'?r='.time().'"/>' . "\n";
                } else {
                    echo '<link rel="stylesheet" type="text/css" href="'.$file.'?r='.time().'"/>' . "\n";
                }
            }
        }
    ?>

    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/jquery/jquery.min.js?r='.time()?>"></script>
    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/bootstrap/js/bootstrap.bundle.min.js?r='.time()?>"></script>

    <!-- Dynamic scripts -->
    <?php
        if (@$scripts) {
            foreach($scripts as $file) {
                if (is_array($file)) {
                    if ($file['print']) {
                        echo '<script type="text/javascript">' . $file['script'] . '</script>' . "\n";
                    }
                } else {
                    echo '<script type="text/javascript" src="'.$file.'?r='.time().'"></script>' . "\n";
                }
            }
        }
        $user = $_SESSION['user'];
    ?>
</head>
<body class="">
    <header class="nav-header shadow">
        <div class="nav-header-logo pull-left">
            <a class="header-logo" href="<?=$config->baseURL?>" title="Jagowebdev">
                <img src="<?=$config->baseURL . 'images/' . $settingAplikasi['logo_app']?>"/>
            </a>
        </div>
        <div class="pull-left nav-header-left">
            <ul class="nav-header">
                <li>
                    <a href="#" id="mobile-menu-btn">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="pull-right mobile-menu-btn-right">
            <a href="#" id="mobile-menu-btn-right">
                <i class="fa fa-ellipsis-h"></i>
            </a>
        </div>
        <div class="pull-right nav-header nav-header-right">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown nav-theme-option">
                    <a class="icon-link nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        $theme_light = $theme_dark = $theme_system = '';
                        
                        if (@$_COOKIE['jwd_adm_theme_system'] == 'true') {
                            $theme_system = 'active';
                            $icon_class = 'bi-circle-half';
                        } else {
                            switch (@$_COOKIE['jwd_adm_theme']) {
                                case 'dark':
                                    $theme_dark = 'active';
                                    $icon_class = 'bi bi-moon-stars';
                                    break;
                                case 'light':
                                default:
                                    $theme_light = 'active';
                                    $icon_class = 'bi bi-sun';
                                    break;          
                            }
                        }
                        ?>
                        <i class="<?=$icon_class?>"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item <?=$theme_light?>" data-theme-value="light">
                                <i class="bi bi-sun me-2"></i>Light
                                <i class="check bi bi-check2 float-end"></i>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item <?=$theme_dark?>" data-theme-value="dark">
                                <i class="bi bi-moon-stars me-2"></i>Dark
                                <i class="check bi bi-check2 float-end"></i>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item <?=$theme_system?>" data-theme-value="system">
                                <i class="bi bi-circle-half me-2"></i>System
                                <i class="check bi bi-check2 float-end"></i>
                            </button>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="icon-link" href="<?=$config->baseURL?>builtin/setting-layout"><i class="bi bi-gear"></i></a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container">
        <p>hallo dari header</p>
        <?php
            $this->renderSection('content')
        ?>
    </div>
</body>
</html>
