<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $allowedFields  = ['email', 'password_hash'];

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
