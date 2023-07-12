<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKembali extends Model
{
    protected $table            = 'mobil';
    protected $primaryKey       = 'id_mobil';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pinjam', 'id_user', 'tgl_kembali', 'kondisi_mobil', 'jml_denda'];
}
