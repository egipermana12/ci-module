<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserTokenTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'selector'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'token'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'action'     => [
                'type'       => 'ENUM',
                'constraint' => ['register','remember','recovery','activation'],
                'null'       => false,
            ],
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'null' => false,
            ],
            'created' => [
                'type'           => 'datetime',
                'null'       => false,
            ],
            'expires' => [
                'type'           => 'datetime',
                'null'       => false,
            ],
         ]);
         $this->forge->addPrimaryKey('selector');
         $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE' , 'fkuser');
         $this->forge->addKey('id_user');
         $this->forge->createTable('user_token');
    }

    public function down()
    {
        $this->forge->dropTable('user_token');
    }
}
