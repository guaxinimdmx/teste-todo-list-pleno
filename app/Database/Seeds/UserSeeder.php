<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'email'         => 'teste@teste.com',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
        ];

        $this->db->table('user')->insert($data);
    }
}
