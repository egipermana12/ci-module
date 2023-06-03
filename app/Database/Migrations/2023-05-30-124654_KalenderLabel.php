<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KalenderLabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nm_label' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'warna' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ] ,
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp', 
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kalender_label');
    }

    public function down()
    {
        $this->forge->dropTable('kalender_label');
    }
}
