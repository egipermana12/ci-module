<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SettingUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'type'    => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'params'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
         $this->forge->addPrimaryKey(['id_user', 'type']);
          $this->forge->createTable('setting_user');
    }

    public function down()
    {
        $this->forge->dropTable('setting_user');
    }
}
