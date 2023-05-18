<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Menu extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_menu' => 1,
                'nama_menu' => 'Dashboard',
                'id_menu_kategori' => 5,
                'class' => 'fas fa-tachometer-alt',
                'url' => 'dashboard',
                'id_module' => 2,
                'id_parent' => NULL,
                'aktif' => 1,
                'new' => 0,
                'urut' => 0
            ],
            [
                'id_menu' => 2,
                'nama_menu' => 'Users',
                'id_menu_kategori' => 5,
                'class' => 'fas fa-users',
                'url' => 'user',
                'id_module' => 3,
                'id_parent' => NULL,
                'aktif' => 1,
                'new' => 0,
                'urut' => 2
            ],

        ];
        $this->db->table('`menu`')->insertBatch($data);
    }
}
