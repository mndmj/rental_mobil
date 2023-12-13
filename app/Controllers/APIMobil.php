<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMobil;
use App\Models\ModelPinjam;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;

class APIMobil extends ResourceController
{
    private $ModelMobil = null;
    private $ModelPeminjman = null;

    public function __construct()
    {
        $this->ModelMobil = new ModelMobil();
        $this->ModelPeminjman = new ModelPinjam();
    }

    public function index()
    {
        throw PageNotFoundException::forPageNotFound();
    }

    public function getall()
    {
        $dtMobils = $this->ModelMobil->select('id_mobil, nama as nama_mobil, merk, no_polisi, foto_mobil, th_keluaran, bahan_bakar, cc_mobil, warna_mobil,harga_sewa, status');
        $justAvailable = false;
        if ($this->validate([
            'available' => 'required|in_list[ya]'
        ])) {
            $dtMobils->where('status', 'Ada');
            $justAvailable = true;
        }
        $dtMobils = $dtMobils->findAll();
        $data = [];
        $i = 0;
        try {
            foreach ($dtMobils as $dtMobil) {
                $now = date("Y-m-d");
                if ($dtMobils[$i]['status'] == "Tidak Ada") {
                    $dtPeminjaman = $this->ModelPeminjman->where('id_mobil', $dtMobils[$i]['id_mobil'])
                        ->where('status_pinjam', 'Dipinjam')
                        ->where("date(tgl_pinjam) <= '$now'")
                        ->where("date(tgl_kembali) >= '$now'")
                        ->first();
                    if (!empty($dtPeminjaman)) {
                        $dtMobils[$i]['tgl_pinjam'] = $dtPeminjaman['tgl_pinjam'];
                        $dtMobils[$i]['estimasi_tgl_kembali'] = $dtPeminjaman['tgl_kembali'];
                    }
                } else {
                    $dtPeminjaman = $this->ModelPeminjman->where('id_mobil', $dtMobils[$i]['id_mobil'])
                        ->where("date(tgl_pinjam) <= '$now'")
                        ->where("date(tgl_kembali) >= '$now'")
                        ->first();
                    if (!empty($dtPeminjaman)) {
                        if ($justAvailable) {
                            unset($dtMobils[$i]);
                        } else {
                            $dtMobils[$i]['status'] = "Dibooking";
                        }
                    }
                }
                $i++;
            }
            $data = $dtMobils;
        } catch (\Throwable $th) {
            $data[0] = $dtMobils;
        }
        return $this->respond($data);
    }

    public function get()
    {
        if (!$this->validate([
            'id_mobil' => 'required|is_natural_no_zero'
        ])) {
            return $this->fail("Data tidak valid");
        }
        $dtMobil =  $this->ModelMobil->select('id_mobil, nama as nama_mobil, merk, no_polisi, foto_mobil, th_keluaran, bahan_bakar, cc_mobil, warna_mobil,harga_sewa, status')
            ->find($this->request->getPost('id_mobil'));
        if (empty($dtMobil)) {
            return $this->fail("Data mobil tidak ditemukan");
        }
        $now = date("Y-m-d");
        if ($dtMobil['status'] == "Tidak Ada") {
            $dtPeminjaman = $this->ModelPeminjman->where('id_mobil', $dtMobil['id_mobil'])
                ->where('status_pinjam', 'Dipinjam')
                ->where("date(tgl_pinjam) < '$now'")
                ->where("date(tgl_kembali) > '$now'")
                ->first();
            if (!empty($dtPeminjaman)) {
                $dtMobil['tgl_pinjam'] = $dtPeminjaman['tgl_pinjam'];
                $dtMobil['estimasi_tgl_kembali'] = $dtPeminjaman['tgl_kembali'];
            }
        } else {
            $dtPeminjaman = $this->ModelPeminjman->where('id_mobil', $dtMobil['id_mobil'])
                ->where("date(tgl_pinjam) <= '$now'")
                ->where("date(tgl_kembali) >= '$now'")
                ->first();
            if (!empty($dtPeminjaman)) {
                $dtMobil['status'] = "Dibooking";
            }
        }
        return $this->respond($dtMobil);
    }

    public function cekketersediaan()
    {
        if (!$this->validate([
            'id_mobil' => 'required|is_natural_no_zero',
            'tgl_pinjam' => 'required|valid_date[d-m-Y H:i]',
            'durasi' => 'required|is_natural_no_zero',
            'type' => 'required|in_list[sekarang,booking]'
        ])) {
            $msg = [
                'success' => false,
                'msg' => "Data tidak valid"
            ];
        } else {
            $dtMobil = $this->ModelMobil->find($this->request->getPost('id_mobil'));
            if (empty($dtMobil)) {
                $msg = [
                    'success' => false,
                    'msg' => 'Mobil tidak ditemukan'
                ];
            } else {
                if ($this->ModelMobil->checkStatus($dtMobil['id_mobil'], $this->request->getPost("tgl_pinjam"), $this->request->getPost("durasi"))) {
                    $msg = [
                        'success' => true,
                        'msg' => 'Mobil dapat dipinjam pada tanggal dan durasi yang diajukan'
                    ];
                } else {
                    $msg = [
                        'success' => false,
                        'msg' => 'Mobil tidak dapat dipinjam pada tanggal dan durasi yang diajukan'
                    ];
                }
            }
        }
        return $this->respond($msg);
    }
}
