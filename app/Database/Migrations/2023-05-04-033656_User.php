<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
                'unique'     => true,
            ],
            'username'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
                'unique'     => true,
            ],
            'nama'    => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'password'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'verified'    => [
                'type'       => 'TINYINT',
                'constraint' => 4,
                'null'       => false,
            ],
            'status'     => [
                'type'       => 'ENUM',
                'constraint' => ['active','suspended','deleted'],
                'default'    => 'active',
                'null'       => false,
            ],
            'avatar'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'default_page_type'     => [
                'type'       => 'ENUM',
                'constraint' => ['url','id_module','id_role'],
                'null'       => true,
            ],
            'default_page_url'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'default_page_id_module'    => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'null'       => true,
            ],
            'default_page_id_role'    => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_user');
        $this->forge->addKey('default_page_id_role', false, false, 'user_role');
        $this->forge->addKey('default_page_id_module');
        $this->forge->addForeignKey('default_page_id_module', 'module', 'id_module', 'CASCADE', 'CASCADE', 'user_module');
        $this->forge->addForeignKey('default_page_id_role', 'role', 'id_role', 'CASCADE', 'CASCADE', 'user_role');
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
