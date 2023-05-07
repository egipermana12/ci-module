<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_role' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_role'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
                'unique'    => true
            ],
            'judul_role'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'keterangan'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'id_module' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => true
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_role');
        $this->forge->addForeignKey('id_module', 'module', 'id_module', 'CASCADE', 'CASCADE' , 'fkmodule');
        $this->forge->addKey('id_module');
        $this->forge->createTable('role');
    }

    public function down()
    {
        $this->forge->dropTable('role');
    }
}
