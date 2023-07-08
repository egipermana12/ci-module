<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TKdProvinsiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_provinsi' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'null' => false,
                'default' => '00',
            ],
            'nm_provinsi' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_provinsi');
        $this->forge->createTable('t_kd_provinsi');
    }

    public function down()
    {
        $this->forge->dropTable('t_kd_provinsi');
    }
}
