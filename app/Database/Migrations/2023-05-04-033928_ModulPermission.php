<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModulPermission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_module_permission' => [
                'type'           => 'SAMLLINT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_module' => [
                'type'           => 'SAMLLINT',
                'constraint'     => 10,
                'unsigned'       => true,
                'null' => false,
                'default' => 0,
            ],
            'nama_permission'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'judul_permission'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'keterangan'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_module_permission');
        $this->forge->addKey(['id_module','nama_permission'], false, true, 'id_module_nama_permission');
        $this->forge->addForeignKey('id_module', 'module', 'id_module', 'CASCADE', 'CASCADE', 'module_permission_module');
        $this->forge->createTable('module_permission');
    }

    public function down()
    {
        $this->forge->dropTable('module_permission');
    }
}
