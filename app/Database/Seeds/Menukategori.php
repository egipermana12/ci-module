<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Menukategori extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_menu_kategori' => 1,
                'nama_kategori' => 'Aplikasi',
                'deskripsi' => 'Menu pengaturan aplikasi',
                'aktif' => 'Y',
                'show_title' => 'Y',
                'urut' => 2,
            ],
            [
              'id_menu_kategori' => 2,
              'nama_kategori' => 'Form & Tabel',
              'deskripsi' => 'Berbagai implementasi Form HTML dan Tabel',
              'aktif' => 'Y',
              'show_title' => 'Y',
              'urut' => 3,  
          ],
          [
              'id_menu_kategori' => 3,
              'nama_kategori' => 'Form & Tabel',
              'deskripsi' => 'Menampilkan data dalam bentuk chart',
              'aktif' => 'Y',
              'show_title' => 'Y',
              'urut' => 4,  
          ],
          [
              'id_menu_kategori' => 4,
              'nama_kategori' => 'Lainnya',
              'deskripsi' => 'Liannya',
              'aktif' => 'Y',
              'show_title' => 'Y',
              'urut' => 5,  
          ],
          [
              'id_menu_kategori' => 5,
              'nama_kategori' => 'Dashboard',
              'deskripsi' => 'Multipurpose dashboard',
              'aktif' => 'Y',
              'show_title' => 'Y',
              'urut' => 1,  
          ],
      ];
      $this->db->table('`menu_kategori')->insertBatch($data);
  }
}
