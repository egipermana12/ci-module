<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TKdKabKelTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelurahan' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'null' => false,
                'default' => '00',
            ],
            'nm_kecamatan' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'id_kecamatan' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'null' => false,
                'default' => '00',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_kelurahan');
        $this->forge->createTable('t_kd_kelurahan');
    }

    public function down()
    {
        $this->forge->dropTable('t_kd_kelurahan');
    }
}
