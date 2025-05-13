<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TaskSeader extends Seeder
{
    public function run()
    {
        $data = [
            ['list_id' => 1, 'description' => 'Comprar arroz', 'is_done' => false],
            ['list_id' => 1, 'description' => 'Comprar feijão', 'is_done' => true],
            ['list_id' => 2, 'description' => 'Implementar login com JWT', 'is_done' => true],
            ['list_id' => 2, 'description' => 'Proteger rotas com filtro', 'is_done' => true],
            ['list_id' => 2, 'description' => 'Criar migrations e seeds', 'is_done' => true],
            ['list_id' => 2, 'description' => 'Organizar rotas REST', 'is_done' => true],
            ['list_id' => 2, 'description' => 'Responder com estrutura padronizada', 'is_done' => true],
            ['list_id' => 2, 'description' => 'Montar frontend desacoplado', 'is_done' => true],
        ];

        $this->db->table('task')->insertBatch($data);
    }
}
