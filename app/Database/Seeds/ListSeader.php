<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ListSeader extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            ['user_id' => 1, 'title' => 'Compras da semana', 'created_at' => $now],
            ['user_id' => 1, 'title' => 'Completar todo pleno', 'created_at' => $now],
        ];

        $this->db->table('list')->insertBatch($data);
    }
}
