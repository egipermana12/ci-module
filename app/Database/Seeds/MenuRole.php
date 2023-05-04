<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuRole extends Seeder
{
    public function run()
    {
         $data = [
            [
                'id_menu' => 1,
                'id_role' => 1
            ],
            [
                'id_menu' => 1,
                'id_role' => 2
            ],
            [
                'id_menu' => 2,
                'id_role' => 1
            ],
            [
                'id_menu' => 2,
                'id_role' => 2
            ],
        ];
        $this->db->table('`menu_role`')->insertBatch($data);
    }
}
