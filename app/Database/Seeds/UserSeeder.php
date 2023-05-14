<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'email' => 'prawoto.hadi@gmail.com',
                'username' => 'admin',
                'nama' => 'Agus Prawoto Hadi',
                'password' => password_hash('12345', PASSWORD_BCRYPT),
                'verified' => 1,
                'status' => 'active',
                'avatar' => 'default.png',
                'default_page_type' => 'id_module',
                'default_page_url' => NULL,
                'default_page_id_module' => 2,
                'default_page_id_role' => 1
            ],
            [
                'id_user' => 2,
                'email' => 'superuser@gmail.com',
                'username' => 'superuser',
                'nama' => 'Super User',
                'password' => password_hash('12345', PASSWORD_BCRYPT),
                'verified' => 1,
                'status' => 'active',
                'avatar' => 'default.png',
                'default_page_type' => 'id_module',
                'default_page_url' => NULL,
                'default_page_id_module' => 3,
                'default_page_id_role' => 1
            ]
        ];
        $this->db->table('user')->insertBatch($data);
    }
}
