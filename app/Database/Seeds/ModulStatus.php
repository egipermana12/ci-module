<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModulStatus extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_module_status' => 1,
                'nama_status' => 'Aktif',
                'keterangan' => NULL
            ],
            [
                'id_module_status' => 2,
                'nama_status' => 'Tidak Aktif',
                'keterangan' => NULL
            ],
            [
                'id_module_status' => 3,
                'nama_status' => 'Dalam Perbaikan',
                'keterangan' => 'Hanya role developer yang dapat mengakses module dengan status ini'
            ],
        ];
        $this->db->table('`module_status`')->insertBatch($data);
    }
}
