<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailUser extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_user';
    protected $primaryKey       = 'id_detail_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'nik', 'nama', 'nama', 'telepon', 'alamat', 'jk'
    ];
}
