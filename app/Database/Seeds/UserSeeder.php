<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            'email' => 'teste@teste.com',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
            'created_at' => $now
        ];

        $this->db->table('user')->insert($data);
    }
}
