<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuKategorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_menu_kategori' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kategori'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'deskripsi'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'aktif'     => [
                'type'       => 'ENUM',
                'constraint' => ['Y','N'],
                'default'    => NULL,
            ],
            'show_title'     => [
                'type'       => 'ENUM',
                'constraint' => ['Y','N'],
                'default'    => NULL,
            ],
            'urut' => [
                'type'           => 'TINYINT',
                'constraint'     => 3,
                'unsigned'       => true,
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_menu_kategori');
        $this->forge->createTable('menu_kategori');
    }

    public function down()
    {
        $this->forge->dropTable('menu_kategori');
    }
}
