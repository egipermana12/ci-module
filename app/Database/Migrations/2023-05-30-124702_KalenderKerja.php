<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KalenderKerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_kalender_label'  => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => true,
            ],
            'tgl_mulai_kegiatan' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tgl_selesai_kegiatan' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'nm_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ] ,
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp', 
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_kalender_label', 'kalender_label', 'id', 'CASCADE', 'CASCADE' , 'fk_kal_label');
        $this->forge->createTable('kalender_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('kalender_kerja');
    }
}
