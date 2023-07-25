<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPinjam extends Model
{
    protected $table            = 'transaksi_pinjam';
    protected $primaryKey       = 'id_pinjam';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_user', 'id_mobil', 'nama_user', 'status_pinjam', 'tgl_pinjam', 'tgl_pesan', 'tgl_kembali',  'telepon', 'jaminan', 'sopir', 'id_sopir', 'created_at'
    ];
}
