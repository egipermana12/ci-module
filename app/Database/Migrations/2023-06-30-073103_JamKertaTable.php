<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JamKertaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jam_kerja' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
                'auto_increment' => true,
            ],
            'nm_shift' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'jam_mulai_kerja' => [
                'type'           => 'TIME',
                'null' => false,
                'default' => '08:00'
            ],
            'jam_selesai_kerja' => [
                'type'           => 'TIME',
                'null' => false,
                'default' => '08:00'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_jam_kerja');
        $this->forge->createTable('t_jam_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('t_jam_kerja');
    }
}
