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
<html lang="en" data-bs-theme="<?=@$_COOKIE['jwd_adm_theme'] ?: 'light'?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$site_title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/bootstrap/css/bootstrap.min.css?' ?>">
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/fontawesome/css/all.css?r='?>"/>
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/bootstrap-icons/bootstrap-icons.css?r='?>"/>
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/dashboard.css?r=' ?>">
    <!-- untuk dark theme -->
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/theme/dark-theme.css?r=' ?>">

    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" class="csrf">

    <!-- untuk css custom dari setting -->
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/theme/color-scheme/'.$app_layout['color_scheme'].'.css?r=' ?>">    
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/bootswatch/'.$app_layout['bootswatch_theme'].'/bootstrap.min.css?r=' ?>">   
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/theme/color-scheme/'.$app_layout['sidebar_color'].'-sidebar.css?r=' ?>">      
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'assets/css/theme/color-scheme/'.$app_layout['logo_background_color'].'-logo-background.css?r=' ?>">    


    <!-- sweetalert -->
    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/sweetalert2/sweetalert2.all.min.js' ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/sweetalert2/sweetalert2.min.css' ?>"/>


    <!-- Dynamic style -->
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

    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/jquery/jquery.min.js?r='?>"></script>
    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/js.cookie/js.cookie.min.js'?>"></script>
    <script type="text/javascript" src="<?=$config->baseURL . 'assets/js/header.js?r='?>"></script>
    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/bootstrap/js/bootstrap.bundle.min.js?r='?>"></script>

    <!-- daterange -->
    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/daterangepicker/moment.min.js' ?>"></script>
    <script type="text/javascript" src="<?=$config->baseURL . 'vendors/daterangepicker/daterangepicker.js' ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=$config->baseURL . 'vendors/daterangepicker/daterangepicker.css' ?>"/>

    <!-- Dynamic scripts -->
    <?php
    if (@$scripts) {
        foreach($scripts as $file) {
            if (is_array($file)) {
                if ($file['print']) {
                    echo '<script type="text/javascript">' . $file['script'] . '</script>' . "\n";
                }
            } else {
                echo '<script type="text/javascript" src="'.$file.'?r='.'"></script>' . "\n";
            }
        }
    }
        //ambil session user
    $user = session()->get('user');
    ?>
</head>
<body class="<?=@$_COOKIE['jwd_adm_mobile'] ? 'mobile-menu-show' : ''?>">

    <div id='TukLoading'></div>
    
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
                <li class="ps-2 nav-account">
                    <?php 
                    $img_url = !empty($user['avatar']) && file_exists(ROOTPATH . 'images/user/' . $user['avatar']) ?
                    $config->baseURL . 'images/user/' . $user['avatar'] : $config->baseURL . 'images/user/default.png';
                    $account_link = $config->baseURL . 'user';
                    ?>
                    <a class="profile-btn" href="<?=$account_link?>" data-bs-toggle="dropdown"><img src="<?=$img_url?>" alt="user_img"></a>
                    <?php 
                    if($login) { ?>
                        <ul class="dropdown-menu">
                            <li class="dropdown-profile px-4 pt-4 pb-2">
                                <div class="avatar">
                                    <a href="<?=$config->baseURL . 'builtin/user/edit?id=' . $user['id_user'];?>">
                                        <img src="<?=$img_url?>" alt="user_img">
                                    </a>
                                </div>
                                <div class="card-content mt-3">
                                    <p><?=strtoupper($user['nama'])?></p>
                                    <p><small>Email: <?=$user['email']?></small></p>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="<?=$config->baseURL?>builtin/user/edit-password">Change Password</a>
                            </li>
                            <li>
                                <li><a class="dropdown-item py-2" href="<?=$config->baseURL?>login/logout">Logout</a></li>
                            </li>
                        </ul>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </header>

    <div class="site-content">
        <div class="sidebar-guide">
            <div class="arrow" style="font-size:18px">
                <i class="fa-solid fa-angles-right"></i>
            </div>
        </div>
        <div class="sidebar shadow">
            <nav>
                <?php foreach($menu as $val) {
                    $kategori = $val['kategori'];
                    if($kategori['show_title'] == 'Y')
                    {
                        echo '<div class="menu-kategori"> 
                        <div class="menu-kategori-wrapper">
                        <h6 class="title">' . $kategori['nama_kategori'] . '</h6>
                        ';
                        if($kategori['deskripsi'])
                        {
                            echo '<small class="description">' . $kategori['deskripsi'] . '</small>';
                        }
                        echo '</div>
                        </div>';
                    }
                    $list_menu = menu_list($val['menu']);
                    echo build_menu($currentModule, $list_menu);
                } ?>
            </nav>
        </div>
        <div class="content">
            <!-- <?=!empty($breadcrumb) ? breadcrumb($breadcrumb) : ''?> -->
            <div class="content-wrapper">
                <?php
                $this->renderSection('content'); 
                ?>
            </div>
        </div>
    </div>
</body>
</html>
