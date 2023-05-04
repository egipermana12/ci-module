<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Role extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_role' => 1,
                'nama_role' => 'admin',
                'judul_role' => 'Administrator',
                'keterangan' => 'Administrator',
                'id_module' => 46
            ],
            [
                'id_role' => 2,
                'nama_role' => 'user',
                'judul_role' => 'User',
                'keterangan' => 'Pengguna Umum',
                'id_module' => 5
            ],
            [
                'id_role' => 3,
                'nama_role' => 'webdev',
                'judul_role' => 'Web Developer',
                'keterangan' => 'Pengembang aplikasi',
                'id_module' => 5
            ]
        ];
        $this->db->table('role')->insertBatch($data);
    }
}
