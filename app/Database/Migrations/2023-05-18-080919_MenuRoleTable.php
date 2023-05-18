<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuRoleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_menu' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
            ],
            'id_role' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => false,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addForeignKey('id_menu', 'menu', 'id_menu', 'CASCADE', 'CASCADE' , 'fkmenurole');
        $this->forge->addForeignKey('id_role', 'role', 'id_role', 'CASCADE', 'CASCADE' , 'fkrolerole');
        $this->forge->addKey('id_menu', false, false, 'module_role_module');
        $this->forge->addKey('id_role', false, false, 'module_role_role');
        $this->forge->createTable('menu_role');
    }

    public function down()
    {
        $this->forge->dropTable('menu_role');
    }
}
