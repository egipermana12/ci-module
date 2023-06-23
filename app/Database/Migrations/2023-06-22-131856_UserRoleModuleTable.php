<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserRoleModuleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_role_module' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'id_module' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['read','write','disable'],
                'null' => false,
                'default' => 'disable'
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_role_module');
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE' , 'fkiduserrolemodule');
        $this->forge->addForeignKey('id_module', 'module', 'id_module', 'CASCADE', 'CASCADE' , 'fkmoduleroleuser');
        $this->forge->addKey(['id_user', 'id_module']);
        $this->forge->createTable('user_role_module');
    }

    public function down()
    {
        $this->forge->dropTable('user_role_module');
    }
}
