<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModuleStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_module_status' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'auto_increment' => true,
            ],
            'nama_status'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addPrimaryKey('id_module_status');
        $this->forge->createTable('module_status');
    }

    public function down()
    {
        $this->forge->dropTable('module_status');
    }
}
