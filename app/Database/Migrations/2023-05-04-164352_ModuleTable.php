<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModuleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_module' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_module'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'unique' => true,
            ],
            'judul_module'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'id_module_status' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'null'  => true,
            ],
            'login'     => [
                'type'       => 'ENUM',
                'constraint' => ['Y','N','R'],
                'default'    => 'Y',
                'null'       => true,
            ],
            'deskripsi'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
        ]);
         $this->forge->addPrimaryKey('id_module');
         $this->forge->addForeignKey('id_module_status', 'module_status', 'id_module_status', 'CASCADE', 'CASCADE' , 'fkmodule_status');
         $this->forge->addKey('id_module_status');
         $this->forge->createTable('module');
    }

    public function down()
    {
        $this->forge->dropTable('module');
    }
}
