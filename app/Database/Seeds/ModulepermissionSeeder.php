<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModulepermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_module_permission' => 1,
                'id_module' => 4,
                'nm_permission' => 'create',
                'judul_permission' => 'Create Data',
                'ket' => 'Hak akses untuk menambah data',
            ],
            [
                'id_module_permission' => 2,
                'id_module' => 5,
                'nm_permission' => 'create',
                'judul_permission' => 'Create Data',
                'ket' => 'Hak akses untuk menambah data',
            ],
            [
                'id_module_permission' => 3,
                'id_module' => 6,
                'nm_permission' => 'create',
                'judul_permission' => 'Create Data',
                'ket' => 'Hak akses untuk menambah data',
            ],
            [
                'id_module_permission' => 4,
                'id_module' => 4,
                'nm_permission' => 'read',
                'judul_permission' => 'Read Data',
                'ket' => 'Hak akses untuk membaca data',
            ],
            [
                'id_module_permission' => 5,
                'id_module' => 5,
                'nm_permission' => 'read',
                'judul_permission' => 'Read Data',
                'ket' => 'Hak akses untuk membaca data',
            ],
            [
                'id_module_permission' => 6,
                'id_module' => 6,
                'nm_permission' => 'read',
                'judul_permission' => 'Read Data',
                'ket' => 'Hak akses untuk membaca data',
            ],
            [
                'id_module_permission' => 7,
                'id_module' => 4,
                'nm_permission' => 'update',
                'judul_permission' => 'Update Data',
                'ket' => 'Hak akses untuk mengudate data',
            ],
            [
                'id_module_permission' => 8,
                'id_module' => 5,
                'nm_permission' => 'update',
                'judul_permission' => 'Update Data',
                'ket' => 'Hak akses untuk mengudate data',
            ],
            [
                'id_module_permission' => 9,
                'id_module' => 6,
                'nm_permission' => 'update',
                'judul_permission' => 'Update Data',
                'ket' => 'Hak akses untuk mengudate data',
            ],
            [
                'id_module_permission' => 10,
                'id_module' => 4,
                'nm_permission' => 'delete',
                'judul_permission' => 'Delete Data',
                'ket' => 'Hak akses untuk menghapus data',
            ],
            [
                'id_module_permission' => 11,
                'id_module' => 5,
                'nm_permission' => 'delete',
                'judul_permission' => 'Delete Data',
                'ket' => 'Hak akses untuk menghapus data',
            ],
            [
                'id_module_permission' => 12,
                'id_module' => 6,
                'nm_permission' => 'delete',
                'judul_permission' => 'Delete Data',
                'ket' => 'Hak akses untuk menghapus data',
            ],
        ];
        $this->db->table('module_permission')->insertBatch($data);
    }
}
