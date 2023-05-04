<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Setting extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'          => false,
            ],
            'param' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'          => false,
            ],
            'value' => [
                'type'           => 'TINYTEXT',
                'null'          => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey(['type', 'param']);
        $this->forge->createTable('setting');
    }

    public function down()
    {
        $this->forge->dropTable('setting');
    }
}
