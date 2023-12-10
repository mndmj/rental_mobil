<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMobil;
use App\Models\ModelPinjam;
use App\Models\ModelUser;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;

class APITransaksi extends ResourceController
{
    private $ModelPinjam = null;
    private $ModelMobil = null;
    private $ModelUser = null;

    public function __construct()
    {
        $this->ModelPinjam = new ModelPinjam();
        $this->ModelMobil = new ModelMobil();
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        throw PageNotFoundException::forPageNotFound();
    }

    public function get()
    {
        if (!$this->validate([
            'id_user' => 'required|is_natural_no_zero'
        ])) {
            return $this->setFail('Data tidak valid');
        }
        $dtTransaksi = $this->ModelPinjam->select('tgl_pinjam, transaksi_kembali.created_at as tgl_kembali, mobil.nama as nama_mobil, no_polisi as nopol')
            ->join('transaksi_kembali', 'transaksi_pinjam.id_pinjam = transaksi_kembali.id_pinjam')
            ->join('mobil', 'transaksi_pinjam.id_mobil = mobil.id_mobil')
            ->where('id_user', $this->request->getPost('id_user'))
            ->findAll();
        return $this->respond($dtTransaksi);
    }

    // Untuk setting biaya sopir
    public function getbiayasopir()
    {
        return $this->respond([
            'biayaSopir' => 100000
        ]);
    }

    public function save()
    {
        if (!$this->validate([
            'id_user' => 'request|is_natural_no_zero',
            'id_mobil' => 'request|is_natural_no_zero',
            'tgl_pinjam' => 'request|valid_date[d-m-Y H:i]',
            'type' => 'required|in_list[sekarang,booking]',
            'durasi' => 'required|is_natural_no_zero',
            'telepon' => 'required|numeric|min_length[9]|max_length[15]',
            'sopir' => 'required|in_list[iya,tidak]'
        ])) {
            $msg = [
                'success' => true,
                'msg' => 'Data tidak valid'
            ];
        } else {
            $dtUser = $this->ModelUser->where('id_user', $this->request->getPost('id_user'))
                ->where('id_role', '2')
                ->first();
            if (empty($dtUser)) {
                $msg = [
                    'success' => true,
                    'msg' => 'Data akun tidak ditemukan'
                ];
            } else {
                $dtMobil = $this->ModelMobil->where('id_mobil', $this->request->getPost('id_mobil'))
                    ->where('status', 'Ada')
                    ->first();
                if (empty($dtMobil)) {
                    $msg = [
                        'success' => true,
                        'msg' => 'Data mobil tidak ditemukan'
                    ];
                } else {
                    if (!$this->ModelMobil->checkStatus($dtMobil['id_mobil'], $this->request->getPost('tgl_pinjam'), $this->request->getPost('durasi'))) {
                        $msg = [
                            'success' => true,
                            'msg' => 'Mobil tidak bisa disewa'
                        ];
                    } else {
                        if ($this->request->getPost('type') == "sekarang") {
                            $tgl_pinjam = date("Y-m-d H:i");
                        } else {
                            $tgl_pinjam = date("Y-m-d H:i", strtotime((string)$this->request->getPost('tgl_pinjam')));
                        }
                        $durasi = $this->request->getPost('durasi');
                        $tgl_kembali = date("Y-m-d H:i", strtotime("$tgl_pinjam +$durasi day"));
                        if ($this->request->getPost('type') == "sekarang") {
                            $status = "Dipinjam";
                        } else {
                            $status = "Booking";
                        }
                        $data = [
                            'id_user' => $dtUser['id_user'],
                            'id_mobil' => $dtMobil['id_mobil'],
                            'status_pinjam' => $status,
                            'tgl_pinjam' => $tgl_pinjam,
                            'tgl_pesan' => date("Y-m-d H:i:s"),
                            'tgl_kembali' => $tgl_kembali,
                            'telepon' => $this->request->getPost('telepon'),
                            'sopir' => $this->request->getPost('sopir')
                        ];
                        $this->ModelPinjam->insert($data);
                        $dtPinjam = $this->ModelPinjam->where('id_user', $dtUser['id_user'])
                            ->where('id_mobil', $this->request->getPost('id_mobil'))
                            ->where('status_pinjam', $status)
                            ->where('tgl_pinjam', $tgl_pinjam)
                            ->where('telepon', $this->request->getPost('telepon'))
                            ->first();
                        if (empty($dtPinjam)) {
                            $msg = [
                                'success' => false,
                                'msg' => 'Data gagal dimasukan. Silahkan coba lagi nanti'
                            ];
                        } else {
                            $msg = [
                                'success' => true,
                                'msg' => 'Data berhasil dimasukan'
                            ];
                        }
                    }
                }
            }
        }
        return $this->respond($msg);
    }

    public function getbytanggal()
    {
        if (!$this->validate([
            'id_user' => 'request|is_natural_no_zero',
            'id_mobil' => 'request|is_natural_no_zero',
            'tgl_pinjam' => 'request|valid_date[d-m-Y H:i]',
            'type' => 'required|in_list[sekarang,booking]'
        ])) {
            return $this->fail("Data tidak valid");
        }
        if ($this->request->getPost('type') == "booking") {
            $status = "Booking";
        } else {
            $status = "Dipinjam";
        }
        $dtPinjam = $this->ModelPinjam->select('tgl_pinjam, tgl_pesan, transaksi_pinjam.tgl_kembali as tgl_estimasi_kembali, tgl_telepon')
            ->join('transaksi_kembali', 'transaksi_kembali.id_pinjam = transaksi_pinjam.id_pinjam', 'left')
            ->where('id_mobil', $this->request->getPost('id_pinjam'))
            ->where('date(tgl_pinjam)', date("Y-m-d", strtotime((string)$this->request->getPost('tgl_pinjam'))))
            ->where('id_user', $this->request->getPost('id_user'))
            ->first();
        if (empty($dtPinjam)) {
            return $this->fail("Data peminjaman tidak ditemukan");
        }
        return $this->respond($dtPinjam);
    }

    public function isonbooking()
    {
        if (!$this->validate([
            'id_user' => 'required|is_natural_no_zero'
        ])) {
            $msg = [
                'success' => false,
                'msg' => 'Data tidak valid'
            ];
        } else {
            $dtUser = $this->ModelUser->find($this->request->getPost('id_user'));
            if (empty($dtUser)) {
                $msg = [
                    'success' => false,
                    'msg' => 'Data akun tidak ditemukan'
                ];
            } else {
                $dtPinjam = $this->ModelPinjam->where('id_user', $dtUser['id_user'])->whereIn('status_pinjam', ['Booking', 'Dipinjam'])->first();
                if (empty($dtPinjam)) {
                    $msg = [
                        'success' => false,
                        'msg' => 'Anda tidak terdaftar pada transaksi peminjaman saat ini '
                    ];
                } else {
                    $msg = [
                        'success' => true,
                        'msg' => 'Anda masih terdaftar pada transaksi peminjaman saat ini'
                    ];
                }
            }
        }
        return $this->respond($msg);
    }

    public function getbyuser()
    {
        if (!$this->validate([
            'id_user' => 'required|is_natural_no_zero'
        ])) {
            return $this->fail("Data tidak valid");
        }
        $dtUser = $this->ModelUser->find($this->request->getPost('id_user'));
        if (empty($dtUser)) {
            return $this->fail("Data user tidak ditemukan");
        }
        $dtPinjam = $this->ModelPinjam->select('status_pinjam, tgl_pinjam, transaksi_pinjam.tgl_kembali as tgl_estimasi_kembali, mobil.id_mobil as id_mobil, sopir, mobil.nama as nama_mobil, no_polisi as nopol')
            ->join('mobil', 'transaksi_pinjam.id_mobil = mobil.id_mobil')
            ->where('id_user', $dtUser['id_user'])->whereIn('status_pinjam', ['Booking', 'Dipinjam'])->first();
        if (empty($dtPinjam)) {
            $msg = [
                'success' => false,
                'msg' => 'Anda tidak terdaftar pada transaksi peminjaman saat ini '
            ];
        } else {
            if ($this->validate([
                'durationOnHours' => 'required|in_list[true]'
            ])) {
                $durasi = ((strtotime($dtPinjam['tgl_estimasi_kembali']) - strtotime(date("Y-m-d H:i:s"))) / (3600));
            } else {
                $durasi = (int)((strtotime($dtPinjam['tgl_estimasi_kembali']) - strtotime($dtPinjam['tgl_pinjam'])) / (3600 * 24));
            }
            $dtPinjam['durasiPinjam'] = $durasi;
            $denda = (int)((strtotime($dtPinjam['tgl_estimasi_kembali']) - strtotime(date("Y-m-d H:i:s"))) / 3600);
            $keterlambatan = ((strtotime($dtPinjam['tgl_estimasi_kembali']) - strtotime(date("Y-m-d H:i:s"))) / 3600);
            if ($denda < 0) {
                $dtPinjam['denda'] = $denda * 20000 * -1;
            } else {
                $dtPinjam['denda'] = 0;
            }
            if ($keterlambatan < 0) {
                if ($keterlambatan > -1) {
                    $keterlambatan = (int)($keterlambatan * 60);
                    $dtPinjam['tenggangWaktu'] = $keterlambatan;
                    $dtPinjam['satuan'] = "Menit";
                } else {
                    $dtPinjam['tenggangWaktu'] = (int)$keterlambatan;
                    $dtPinjam['satuan'] = "Jam";
                }
            } else {
                if ($keterlambatan < 1) {
                    $keterlambatan = (int)($keterlambatan * 60);
                    $dtPinjam['tenggangWaktu'] = $keterlambatan;
                    $dtPinjam['satuan'] = "Menit";
                } else {
                    $dtPinjam['tenggangWaktu'] = (int)$keterlambatan;
                    $dtPinjam['satuan'] = "Jam";
                }
            }
            $msg = [
                'success' => true,
                'msg' => 'Anda masih terdaftar pada transaksi peminjaman saat ini'
            ];
        }
        return $this->respond($dtPinjam);
    }
}
