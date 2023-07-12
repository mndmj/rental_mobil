<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSopir extends Model
{
    protected $table            = 'sopir';
    protected $primaryKey       = 'id_sopir';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $deletedField     = 'delete_at';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nik', 'nama', 'alamat', 'telepon', 'delete_at'];
}
