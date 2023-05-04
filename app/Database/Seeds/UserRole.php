<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserRole extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'id_role' => 1
            ],
            [
                'id_user' => 2,
                'id_role' => 1
            ]
        ];
        $this->db->table('user_role')->insertBatch($data);
    }
}
