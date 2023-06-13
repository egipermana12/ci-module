<?php
/**
 * helper util digunakan untuk membuat : 
 * generate menu
 * generate breadcrumb dst
 */

//untuk mengenrate men
function menu_list($result)
{
    $refs = array();
    $list = array();
    // echo '<pre>'; print_r($result);
    foreach($result as $key => $val)
    {
        if(!$key || empty($val['id_menu'])) //Highlight OR No parent
        continue;

        $thisref = &$refs[$val['id_menu']]; //&pada &refs memberi info ke php agar tidak menyalin array saat meneruskan ke fungsi
        foreach($val as $field => $value)
        {
            $thisref[$field] = $value;
        }

        // no parent
        if($val['id_parent'] == 0)
        {
            $list[ $val['id_menu'] ] = &$thisref;
        }else{
            $thisref['depth'] = ++$refs[$val['id_menu']]['depth'];
            $refs[$val['id_parent']]['children'][$val['id_menu']] = $thisref;
        }
    }
    set_depth($list);
    // echo '<pre>'; print_r($list);
    return $list;
}

function build_menu( $current_module, $arr_menu, $submenu = false)
{
    // echo '<pre>'; print_r($arr_menu);
    // echo '<pre>'; print_r($current_module);
    $menu = "\n" . '<ul'.$submenu.'>'."\r\n";

    foreach($arr_menu as $key => $val)
    {
        if (!$key)
            continue;

        // Check new
        $new = '';
        if (key_exists('new', $val)) {
            $new = $val['new'] == 1 ? '<span class="menu-baru">NEW</span>' : '';
        }
        $arrow = key_exists('children', $val) ? '<span class="pull-right-container">
                                <i class="fa fa-angle-left arrow"></i>
                            </span>' : '';
        $has_child = key_exists('children', $val) ? 'has-children' : '';

        if ($has_child) {
            $url = '#';
            $onClick = ' onclick="javascript:void(0)"';
        } else {
            $onClick = '';
            $url = $val['url'];
        }

        // class attribute for <li>
        $class_li = [];     
        if ($current_module['nama_module'] == $val['nama_module']) {
            $class_li[] = 'tree-open';
        }
        
        if ($val['highlight']) {
            $class_li[] = 'highlight tree-open';
        }
        
        if ($class_li) {
            $class_li = ' class="' . join(' ', $class_li) . '"';
        } else {
            $class_li = '';
        }

        // Class attribute for <a>, children of <li>
        $class_a = ['depth-' . $val['depth']];
        if ($has_child) {
            $class_a[] = 'has-children';
        }
        
        $class_a = ' class="' . join(' ', $class_a) . '"';

        // Menu icon
        $menu_icon = '';
        if ($val['class']) {
            $menu_icon = '<i class="sidebar-menu-icon ' . $val['class'] . '"></i>';
        }

        // Menu
        $config = new \Config\App();
        
        if (substr($url, 0, 4) != 'http') {
            $url = $config->baseURL . $url;
        }

        $menu .= '<li'. $class_li . '>
                    <a '.$class_a.' href="'. $url . '"'.$onClick.'>'.
                        '<span class="menu-item">' .
                            $menu_icon.
                            '<span class="text">' . $val['nama_menu'] . '</span>' .
                        '</span>' . 
                        $arrow.
                    '</a>'.$new;
        
        if (key_exists('children', $val))
        {   
            $menu .= build_menu($current_module, $val['children'], ' class="submenu"');
        } 
        $menu .= "</li>\n";
    }
    $menu .= "</ul>\n";
    return $menu;
}

function set_depth(&$result, $depth = 0)
{
    foreach($result as $key => $val)
    {
        $val['depth'] = $depth;
        if (key_exists('children', $val)) {
            set_depth($val['children'], $val['depth'] + 1);
        }
    }
}

function breadcrumb($data)
{
    $separator = '&gt;';
    echo '<nav style="--bs-breadcrumb-divider: '.$separator.';" aria-label="breadcrumb" >
            <ol class="breadcrumb shadow-sm">';
        foreach($data as $title => $url)
        {
            if($url)
            {
                echo '<li class="breadcrumb-item"><a href="'.$url.'">'.$title.'</a></li>';
            }else{
                echo '<li class="breadcrumb-item active" aria-current="page">'.$title.'</li>';
            }
        }
        echo '</ol></nav>';
}
