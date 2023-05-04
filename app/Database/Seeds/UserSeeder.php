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
                'default_page_id_module' => 46,
                'default_page_id_role' => NULL
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
                'default_page_id_module' => 5,
                'default_page_id_role' => NULL
            ]
        ];
        $this->db->table('user')->insertBatch($data);
    }
}
