<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKembali extends Model
{
    protected $table            = 'transaksi_kembali';
    protected $primaryKey       = 'id_kembali';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pinjam', 'id_user', 'tgl_kembali', 'kondisi_mobil', 'jml_denda', 'mobil_rusak', 'kerusakan', 'denda_kerusakan', 'created_at'];
}
