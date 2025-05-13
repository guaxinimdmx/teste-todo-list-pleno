<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
  protected $table = 'task';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useTimestamps = true;

  protected $allowedFields = ['list_id', 'description', 'is_done'];

  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
}
