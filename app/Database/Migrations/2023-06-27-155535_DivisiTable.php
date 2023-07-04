<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DivisiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_divisi_kerja' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
                'auto_increment' => true,
            ],
            'nm_divisi' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'standar_gaji' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
                'null' => false,
                'default' => 0
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_divisi_kerja');
        $this->forge->createTable('t_divisi_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('t_divisi_kerja');
    }
}
