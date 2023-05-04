<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Setting extends Seeder
{
    public function run()
    {
        $data = [
            [
                'type' => 'app',
                'param' => 'background_logo',
                'value' => 'transparent',
            ],
            [
                'type' => 'app',
                'param' => 'btn_login',
                'value' => 'btn-danger',
            ],
            [
                'type' => 'app',
                'param' => 'deskripsi_web',
                'value' => 'Template administrasi lengkap dengan fitur penting dalam pengembangan aplikasi seperti pengatuan web, layout, dll',
            ],
            [
                'type' => 'app',
                'param' => 'favicon',
                'value' => 'favicon.png',
            ],
            [
                'type' => 'app',
                'param' => 'footer_app',
                'value' => '&copy; {{YEAR}} &lt;a href=&quot;https://jagowebdev.com&quot; target=&quot;_blank&quot;&gt;www.Jagowebdev.com&lt;/a&gt;',
            ],
            [
                'type' => 'app',
                'param' => 'footer_login',
                'value' => '&copy; {{YEAR}} &lt;a href=&quot;https://jagowebdev.com&quot; target=&quot;_blank&quot;&gt;Jagowebdev.com&lt;/a&gt;',
            ],
            [
                'type' => 'app',
                'param' => 'judul_web',
                'value' => 'Admin Template Jagowebdev',
            ],
            [
                'type' => 'app',
                'param' => 'logo_app',
                'value' => 'logo_aplikasi.png',
            ],
            [
                'type' => 'app',
                'param' => 'logo_login',
                'value' => 'logo_login.png',
            ],
            [
                'type' => 'app',
                'param' => 'logo_register',
                'value' => 'logo_register.png',
            ],
            [
                'type' => 'layout',
                'param' => 'bootswatch_theme',
                'value' => 'default',
            ],
            [
                'type' => 'layout',
                'param' => 'color_scheme',
                'value' => 'blue',
            ],
            [
                'type' => 'layout',
                'param' => 'font_family',
                'value' => 'poppins',
            ],
            [
                'type' => 'layout',
                'param' => 'font_size',
                'value' => '14.5',
            ],
            [
                'type' => 'layout',
                'param' => 'logo_background_color',
                'value' => 'dark',
            ],
            [
                'type' => 'layout',
                'param' => 'sidebar_color',
                'value' => 'dark',
            ],
            [
                'type' => 'register',
                'param' => 'default_page_id_module',
                'value' => '5',
            ],
            [
                'type' => 'register',
                'param' => 'default_page_id_role',
                'value' => '2',
            ],
            [
                'type' => 'register',
                'param' => 'default_page_type',
                'value' => 'id_module',
            ],
            [
                'type' => 'register',
                'param' => 'default_page_url',
                'value' => '{{BASE_URL}}builtin/user/edit?id=1',
            ],
            [
                'type' => 'register',
                'param' => 'enable',
                'value' => 'Y',
            ],
            [
                'type' => 'register',
                'param' => 'id_role',
                'value' => '2',
            ],
            [
                'type' => 'register',
                'param' => 'metode_aktivasi',
                'value' => 'email',
            ],
        ];
        $this->db->table('`setting`')->insertBatch($data);
    }
}
