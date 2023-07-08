<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TKdKabKotaTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id_kabkota' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'null' => false,
                'default' => '00',
            ],
            'nm_kabkota' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'id_provinsi' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'null' => false,
                'default' => '00',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_kabkota');
        $this->forge->createTable('t_kd_kabkota');
    }

    public function down()
    {
        $this->forge->dropTable('t_kd_kabkota');
    }
}
