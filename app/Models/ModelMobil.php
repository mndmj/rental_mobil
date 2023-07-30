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
    protected $allowedFields    = ['nama', 'merk', 'foto_mobil', 'no_polisi', 'th_keluaran', 'bahan_bakar', 'cc_mobil', 'warna_mobil', 'harga_sewa', 'status', 'delete_at'];

    public function checkStatus($id_mobil, $tanggal, $durasi): bool
    {
        $ModelPeminjman = new ModelPinjam();
        $tglPinjam = date("Y-m-d", strtotime($tanggal));
        $estimasiKembali = date("Y-m-d", strtotime("$tglPinjam +$durasi day"));
        $dtPinjam = $ModelPeminjman->where('id_mobil', $id_mobil)
            ->where("(((date(tgl_pinjam) <= '$tglPinjam' AND  date(tgl_kembali) >= '$tglPinjam')")
            ->orWhere("(date(tgl_pinjam) <= '$estimasiKembali' AND date(tgl_kembali) >= '$estimasiKembali'))")
            ->orWhere("(date(tgl_pinjam) BETWEEN '$tglPinjam' AND '$estimasiKembali'")
            ->orWhere("date(tgl_kembali) BETWEEN '$tglPinjam' AND '$estimasiKembali'))")
            ->first();
        return empty($dtPinjam);
    }
}
