<?php

namespace App\Models;

use CodeIgniter\Model;

class ListModel extends Model
{
    protected $table = 'list';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = ['user_id', 'title'];

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
