<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingUser extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'type' => 'Layout',
                'param' => '{"color_scheme":"blue-dark","sidebar_color":"dark","logo_background_color":"default","font_family":"open-sans","font_size":"15","bootswatch_theme":""}',
            ],
            [
                'id_user' => 2,
                'type' => 'Layout',
                'param' => '{"color_scheme":"green","bootswatch_theme":"default","sidebar_color":"dark","logo_background_color":"dark","font_family":"poppins","font_size":"14.5"}',
            ],
        ];
        $this->db->table('`setting_user`')->insertBatch($data);
    }
}
