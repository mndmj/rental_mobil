<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMobil extends Model
{
    protected $table            = 'mobil';
    protected $primaryKey       = 'id_mobil';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $deletedField     = 'delete_at';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nama', 'merk', 'no_polisi', 'th_keluaran', 'bahan_bakar', 'cc_mobil', 'warna_mobil', 'harga_sewa', 'delete_at'];
}
