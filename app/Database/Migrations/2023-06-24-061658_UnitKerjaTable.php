<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitKerjaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_unit_kerja' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
                'auto_increment' => true,
            ],
            'nm_unit_kerja' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'alamat' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null' => true,
            ],
            'koordinat_lokasi' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => true,
            ],
            'koordinat_bidang' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null' => true,
            ],
            'jarak_toleran' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'null' => true,
            ],
            'gambar' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_unit_kerja');
        $this->forge->createTable('t_unit_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('t_unit_kerja');
    }
}
