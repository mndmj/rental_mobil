<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPinjam extends Model
{
    protected $table            = 'transaksi_pinjam';
    protected $primaryKey       = 'id_pinjam';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_user', 'id_mobil', 'tgl_pinjam', 'nama_user', 'tgl_pesan', 'tgl_kembali', 'jaminan', 'telepon', 'id_sopir', 'created_at'];
}
