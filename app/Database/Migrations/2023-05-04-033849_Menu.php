<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'id_menu' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_menu'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'id_menu_kategori' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'null' => true,
            ],
            'class'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'url'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'id_module' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => true,
            ],
            'id_parent' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => true,
            ],
            'aktif' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'null' => false,
                'default' => 1,
            ],
            'new' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'null' => false,
                'default' => 0,
            ],
            'urut' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'null' => false,
                'default' => 0,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
         $this->forge->addPrimaryKey('id_menu');
         $this->forge->addKey('id_module');
         $this->forge->addKey('id_parent');
         $this->forge->addForeignKey('id_parent', 'menu', 'id_menu', 'CASCADE', 'CASCADE', 'menu_menu');
         $this->forge->addForeignKey('id_module', 'modul', 'id_module', 'CASCADE', 'CASCADE', 'menu_module');
         $this->forge->createTable('menu');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}
