<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'username',
            ],
        ]);

        $users = $this->db->table('users')->select('id')->get()->getResultArray();

        foreach ($users as $user) {
            $this->db->table('users')
                ->where('id', $user['id'])
                ->update([
                    'password' => password_hash('TFA4pass123!', PASSWORD_DEFAULT),
                ]);
        }

        $this->forge->modifyColumn('users', [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'password');
    }
}
