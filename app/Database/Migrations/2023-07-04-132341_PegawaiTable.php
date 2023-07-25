<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PegawaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pegawai' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null' => false,
                'auto_increment' => true,
            ],
            'nik' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'nm_pegawai' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null' => false,
            ],
            'tgl_lahir' => [
                'type'           => 'DATE',
                'null' => false,
            ],
            'jns_kelamin' => [
                'type'           => 'ENUM',
                'constraint' => ['L','P'],
            ],
            'no_hp' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'alamat' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'kd_prov' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'default' => 'NULL',
            ],
            'kd_kab_kota' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'default' => 'NULL',
            ],
            'kd_kec' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'default' => 'NULL',
            ],
            'kd_kel' => [
                'type'           => 'CHAR',
                'constraint'     => '5',
                'default' => 'NULL',
            ],
            'id_unit_kerja' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'id_divisi' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'id_jabatan' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'tgl_bergabung' => [
                'type'           => 'DATE',
                'null' => false,
            ],
            'foto_pegawai' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_pegawai');
        $this->forge->createTable('t_data_pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('t_data_pegawai');
    }
}
