<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Modul extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_module' => 5,
                'nama_module' => 'build/user',
                'judul_module' => 'User Manager',
                'id_module_status' => 1,
                'login' => 'Y',
                'deskripsi' => 'Pengaturan user'
            ],
            [
                'id_module' => 46,
                'nama_module' => 'dashboard',
                'judul_module' => 'Dashboard',
                'id_module_status' => 1,
                'login' => 'Y',
                'deskripsi' => 'PDashboard'
            ],
        ];
        $this->db->table('module')->insertBatch($data);
    }
}
