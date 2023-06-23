<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolemodulepermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_role' => 1,
                'id_module_permission' => 1,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 2,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 3,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 4,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 5,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 6,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 7,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 8,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 9,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 10,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 11,
            ],
            [
                'id_role' => 1,
                'id_module_permission' => 12,
            ],
        ];
        $this->db->table('role_module_permission')->insertBatch($data);
    }
}
