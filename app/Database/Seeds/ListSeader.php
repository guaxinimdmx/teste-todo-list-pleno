<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ListSeader extends Seeder
{
    public function run()
    {
        $data = [
            ['user_id' => 1, 'title' => 'Compras da semana'],
            ['user_id' => 1, 'title' => 'Completar todo pleno'],
        ];

        $this->db->table('list')->insertBatch($data);
    }
}
