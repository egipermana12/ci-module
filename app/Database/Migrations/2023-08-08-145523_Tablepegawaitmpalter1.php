<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tablepegawaitmpalter1 extends Migration
{
    public function up()
    {
        $addfields = [
              'keyfile_flat' => [
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                    'after' => 'tgl_bergabung'
              ],
              'tgl_create' => [
                    'type' => 'datetime',
                    'after' => 'tgl_bergabung'
              ]
         ];
         $this->forge->addColumn('t_data_pegawai_tmp', $addfields);
    }

    public function down()
    {
        //
    }
}
