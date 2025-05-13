<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TaskSeader extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            ['list_id' => 1, 'description' => 'Comprar arroz', 'is_done' => false, 'created_at' => $now],
            ['list_id' => 1, 'description' => 'Comprar feijão', 'is_done' => true, 'created_at' => $now],
            ['list_id' => 2, 'description' => 'Implementar login com JWT', 'is_done' => true, 'created_at' => $now],
            ['list_id' => 2, 'description' => 'Proteger rotas com filtro', 'is_done' => true, 'created_at' => $now],
            ['list_id' => 2, 'description' => 'Criar migrations e seeds', 'is_done' => true, 'created_at' => $now],
            ['list_id' => 2, 'description' => 'Organizar rotas REST', 'is_done' => true, 'created_at' => $now],
            ['list_id' => 2, 'description' => 'Responder com estrutura padronizada', 'is_done' => true, 'created_at' => $now],
            ['list_id' => 2, 'description' => 'Montar frontend desacoplado', 'is_done' => true, 'created_at' => $now],
        ];

        $this->db->table('task')->insertBatch($data);
    }
}
