<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserRole extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'        => 'INT',
                'constraint'  => 10,
                'unsigned'    => true,
                'null'        => false,
            ],
            'id_role' => [
                'type'        => 'SMALLINT',
                'constraint'  => 5,
                'unsigned'    => true,
                'null'        => false,
            ],
        ]);
        $this->forge->addPrimaryKey(['id_user','id_role']);
        $this->forge->addKey('id_user');
        $this->forge->addKey('id_role');
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE', 'user_role_user');
        $this->forge->createTable('user_role');
    }

    public function down()
    {
        $this->forge->dropTable('user_role');
    }
}
