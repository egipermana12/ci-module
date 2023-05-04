<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleModulePermission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_role' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
            ],
            'id_module_permission' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
         $this->forge->addPrimaryKey(['id_role','id_module_permission']);
         $this->forge->addKey('id_module_permission', false, false, 'role_permission_permission');
         $this->forge->addForeignKey('id_module_permission', 'module_permission', 'id_module_permission', 'CASCADE', 'CASCADE', 'role_module_permission_module_permission');
         $this->forge->addForeignKey('id_role', 'role', 'id_role', 'CASCADE', 'CASCADE', 'role_module_permission_role');
         this->forge->createTable('role_module_permission');
    }

    public function down()
    {
        $this->forge->dropTable('role_module_permission');
    }
}
