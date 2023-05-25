<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Modul extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_module' => 3,
                'nama_module' => 'build/user',
                'judul_module' => 'User Manager',
                'id_module_status' => 1,
                'login' => 'Y',
                'deskripsi' => 'Pengaturan user'
            ],
            [
                'id_module' => 2,
                'nama_module' => 'dashboard',
                'judul_module' => 'Dashboard',
                'id_module_status' => 1,
                'login' => 'Y',
                'deskripsi' => 'PDashboard'
            ],
            [
                'id_module' => 1,
                'nama_module' => 'login',
                'judul_module' => 'Login',
                'id_module_status' => 1,
                'login' => 'R',
                'deskripsi' => 'Login ke akun anda'
            ],
        ];
        $this->db->table('module')->insertBatch($data);
    }
}
