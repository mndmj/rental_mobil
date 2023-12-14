<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKembali;
use App\Models\ModelMobil;
use App\Models\ModelPinjam;
use App\Models\ModelSopir;
use CodeIgniter\Exceptions\PageNotFoundException;

class Transaksi extends BaseController
{
    private $ModelPinjam = null;
    private $ModelKembali = null;
    private $ModelMobil = null;
    private $ModelSopir = null;

    public function __construct()
    {
        $this->ModelPinjam = new ModelPinjam();
        $this->ModelKembali = new ModelKembali();
        $this->ModelMobil = new ModelMobil();
        $this->ModelSopir = new ModelSopir();
    }

    public function index()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // PINJAM
    public function pinjam()
    {
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Peminjaman',
            'pinjam' => $this->ModelPinjam
                ->select('*, detail_user.nama as nama_user, mobil.nama as nama_mobil, detail_user.telepon as telepon_user, sopir.telepon as telepon_sopir, transaksi_pinjam.nama_user as peminjam, transaksi_pinjam.telepon as telp_peminjam')
                ->join('user', 'user.id_user = transaksi_pinjam.id_user', 'left')
                ->join('detail_user', 'detail_user.id_user = user.id_user', 'left')
                ->join('mobil', 'mobil.id_mobil = transaksi_pinjam.id_mobil')
                ->join('sopir', 'sopir.id_sopir = transaksi_pinjam.id_sopir', 'left')
                ->where('status_pinjam != "kembali"')
                ->findAll(),
            'mobil' => $this->ModelMobil->where('status', 'Ada')->findAll(),
            'jaminan' => $this->jaminan,
            'biayaSopir' => 100000
        ];
        return view('admin/view_pinjam.php', $data);
    }

    public function savepinjam()
    {
        if (!$this->validate([
            'nama_mobil' => 'required',
            'nama_user' => 'required',
            'ck_tipe_pinjam' => 'required|in_list[sekarang,booking]',
            'durasi_pinjam' => 'required|greater_than_equal_to[1]',
            'telepon' => 'required|numeric|min_length[10]|max_length[15]',
            'sopir' => 'required|in_list[Iya,Tidak]',
            'jaminan' => 'required|in_list[KTP,SIM C,Passport,KK,Kendaraan Bermotor,BPKB]'
        ])) {
            session()->setFlashdata('danger', 'Data tidak valid');
            return $this->redirect();
        }
        $dtMobil = $this->ModelMobil->where('no_polisi', $this->request->getPost('nama_mobil'))->first();
        if (empty($dtMobil)) {
            session()->setFlashdata('danger', 'Data Mobil tidak ditemukan');
            return $this->redirect();
        }
        $data = [
            'id_mobil' => $dtMobil['id_mobil'],
            'nama_user' => $this->request->getPost('nama_user'),
            'tgl_pinjam' => $this->request->getPost('tgl_pinjam'),
            'tgl_pesan' => date("Y-m-d H:i:s"),
            'telepon' => $this->request->getPost('telepon'),
            'jaminan' => $this->request->getPost('jaminan'),
            'sopir' => $this->request->getPost('sopir'),
            'created_at' => date("Y-m-d H:i:s")
        ];
        if ($this->request->getPost('ck_tipe_pinjam') == "sekarang") {
            $data['tgl_pinjam'] = date("Y-m-d H:i:s");
            $data['tgl_kembali'] = date("Y-m-d H:i:s", strtotime("+" . $this->request->getPost('durasi_pinjam') . " day"));
            $data['status_pinjam'] = "Dipinjam";
        } else {
            if (!$this->validate([
                'tgl_pinjam' => 'required'
            ])) {
                session()->setFlashdata('danger', 'Ketika booking, tanggal pinjam harus di isi');
                return $this->redirect();
            }
            $data['tgl_kembali'] = date("Y-m-d H:i:s", strtotime($this->request->getPost('tgl_pinjam') . " +" . $this->request->getPost('durasi_pinjam') . " day"));
            $data['status_pinjam'] = "Booking";
        }
        if ($this->ModelPinjam->insert($data)) {
            $dataMobil = [
                'status' => 'Tidak Ada'
            ];
            $this->ModelMobil->update($dtMobil['id_mobil'], $dataMobil);
            session()->setFlashdata('success', "Data berhasil dimasukan");
        } else {
            session()->setFlashdata('danger', "Data gagal dimasukan");
        }
        return $this->redirect();
    }

    public function detail($id_pinjam)
    {
        $dtTransaksi = $this->ModelPinjam->select('*, detail_user.nama as nama_user, detail_user.telepon as telepon_user, transaksi_pinjam.nama_user as peminjam, transaksi_pinjam.telepon as telp_peminjam')
            ->join('user', 'user.id_user = transaksi_pinjam.id_user', 'left')
            ->join('detail_user', 'detail_user.id_user = user.id_user', 'left')
            ->where('id_pinjam', $id_pinjam)->first();
        if (empty($dtTransaksi)) {
            session()->setFlashdata('danger', "Data transaksi tidak ditemukan");
            return $this->redirect();
        }
        $dtMobil = $this->ModelMobil->find($dtTransaksi['id_mobil']);
        if (empty($dtMobil)) {
            session()->setFlashdata('danger', "Data mobil tidak ditemukan");
            return $this->redirect();
        }
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Detail Peminjaman',
            'dtTransaksi' => $dtTransaksi,
            'dtMobil' => $dtMobil,
            'jaminan' => $this->jaminan,
            'dtSopir' => $this->ModelSopir->findAll()
        ];
        return view('admin/view_detail_pinjam', $data);
    }

    public function  checkin($id_pinjam)
    {
        // Validasi input data
        if (!$this->validate([
            'nama_user' => 'required',
            'telepon' => 'required|numeric',
            'jaminan' => 'required|in_list[KTP,SIM C,Passport,KK,Kendaraan Bermotor,BPKB]'
        ])) {
            return redirect()->to(base_url("transaksi/detail/$id_pinjam"))->with('danger', 'Mohon lengkapi data dengan benar');
        }
        // Validasi data transaksi peminjaman
        $dtTransaksi = $this->ModelPinjam->where('id_pinjam', $id_pinjam)
            ->where('status_pinjam', 'Booking')->first();
        if (empty($dtTransaksi)) {
            return redirect()->to(base_url("transaksi/detail/$id_pinjam"))->with('danger', 'Data transaksi tidak ditemukan');
        }
        // Update data
        $tglBaru = date("Y-m-d H:i:s");
        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'telepon' => $this->request->getPost('telepon'),
            'jaminan' => $this->request->getPost('jaminan'),
            'status_pinjam' => 'Dipinjam',
            'tgl_pinjam' => $tglBaru
        ];
        $this->ModelPinjam->update($id_pinjam, $data);
        // Cek keberhasilan input data
        $dtCek = $this->ModelPinjam->where('id_pinjam', $id_pinjam)
            ->where('nama_user', $this->request->getPost('nama_user'))
            ->where('telepon', $this->request->getPost('telepon'))
            ->where('jaminan', $this->request->getPost('jaminan'))
            ->where('status_pinjam', 'Dipinjam')
            ->where('tgl_pinjam', $tglBaru)
            ->first();
        if (empty($dtCek)) {
            // Jika gagal diupdate
            session()->setFlashdata('danger', 'Data gagal dikonfirmasi. Silahkan coba lagi nanti');
        } else {
            // Jika berhasil diupdate
            session()->setFlashdata('success', 'Data berhasil dikonfirmasi');
        }
        return redirect()->to(base_url("transaksi/detail/$id_pinjam"));
    }

    public function insert_data()
    {
        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'tgl_pesan' => $this->request->getPost('tgl_pesan'),
            'tgl_pinjam' => $this->request->getPost('tgl_pinjam'),
            'telepon' => $this->request->getPost('telepon'),
            'id_mobil' => $this->request->getPost('nama_mobil'),
            'no_polisi' => $this->request->getPost('no_polisi'),
            'jaminan' => $this->request->getPost('jaminan'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->ModelPinjam->insert($data);
        return redirect()->to('transaksi/pinjam')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit_data($id_pinjam)
    {
        $data = [
            'id_user' => $this->request->getPost('nama_user'),
            'tgl_pesan' => $this->request->getPost('tgl_pesan'),
            'tgl_pinjam' => $this->request->getPost('tgl_pinjam'),
            'telepon' => $this->request->getPost('telepon'),
            'id_mobil' => $this->request->getPost('nama_mobil'),
            'no_polisi' => $this->request->getPost('no_polisi'),
        ];
        $this->ModelPinjam->update($id_pinjam, $data);
        return redirect()->to('transaksi/pinjam')->with('warning', 'Data berhasil diedit');
    }

    public function delete_data($id_pinjam)
    {
        $data = [
            'id_pinjam' => $id_pinjam,
        ];
        $this->ModelPinjam->delete($data);
        return redirect()->to('transaksi/pinjam')->with('danger', 'Data berhasil dihapus');
    }

    // KEMBALI
    public function kembali()
    {
        $dtBelumKembali = $this->ModelPinjam->select('*, detail_user.nama as nama_user, mobil.nama as nama_mobil, detail_user.telepon as telepon_user, sopir.telepon as telepon_sopir, transaksi_pinjam.nama_user as peminjam, transaksi_pinjam.telepon as telp_peminjam')
            ->join('user', 'user.id_user = transaksi_pinjam.id_user', 'left')
            ->join('detail_user', 'detail_user.id_user = user.id_user', 'left')
            ->join('mobil', 'mobil.id_mobil = transaksi_pinjam.id_mobil')
            ->join('sopir', 'sopir.id_sopir = transaksi_pinjam.id_sopir', 'left')
            ->where('status_pinjam', 'Dipinjam')->findAll();
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Pengembalian',
            'kembali' => $this->ModelKembali->select('*, detail_user.nama as nama_user, mobil.nama as nama_mobil, detail_user.telepon as telepon_user, sopir.telepon as telepon_sopir, transaksi_pinjam.nama_user as peminjam, transaksi_pinjam.telepon as telp_peminjam')
                ->join('transaksi_pinjam', 'transaksi_pinjam.id_pinjam = transaksi_kembali.id_pinjam')
                ->join('user', 'user.id_user = transaksi_pinjam.id_user', 'left')
                ->join('detail_user', 'detail_user.id_user = user.id_user', 'left')
                ->join('mobil', 'mobil.id_mobil = transaksi_pinjam.id_mobil')
                ->join('sopir', 'sopir.id_sopir = transaksi_pinjam.id_sopir', 'left')
                ->findAll(),
            'mobil' => $this->ModelMobil->where('status', 'Ada')->findAll(),
            'dtBelumKembali' => $dtBelumKembali
        ];
        return view('admin/view_kembali.php', $data);
    }

    public function detail_kembali($id_pinjam)
    {
        $dtTransaksi = $this->ModelPinjam->select('*, detail_user.nama as nama_user, detail_user.telepon as telepon_user, transaksi_pinjam.nama_user as peminjam, transaksi_pinjam.telepon as telp_peminjam')
            ->join('user', 'user.id_user = transaksi_pinjam.id_user', 'left')
            ->join('detail_user', 'detail_user.id_user = user.id_user', 'left')
            ->where('id_pinjam', $id_pinjam)->first();
        if (empty($dtTransaksi)) {
            session()->setFlashdata('danger', "Data transaksi tidak ditemukan");
            return $this->redirect();
        }
        $dtMobil = $this->ModelMobil->find($dtTransaksi['id_mobil']);
        if (empty($dtMobil)) {
            session()->setFlashdata('danger', "Data mobil tidak ditemukan");
            return $this->redirect();
        }
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Detail Pengembalian',
            'dtTransaksi' => $dtTransaksi,
            'dtMobil' => $dtMobil,
            'dtKembali' => $this->ModelKembali->where('id_pinjam', $dtTransaksi['id_pinjam'])->first()
        ];
        return view('admin/view_detail_kembali', $data);
    }

    public function pengembalian()
    {
        if (!$this->validate([
            'id_pinjam' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('danger', 'Data pinjam tidak valid');
            return $this->redirect();
        }
        $crashCar = "Tidak";
        if ($this->validate([
            'crashCar' => 'required'
        ])) {
            if (!$this->validate([
                'denda_kerusakan' => 'required|greater_than_equal_to[1]',
                'kerusakan' => 'required'
            ])) {
                session()->setFlashdata('danger', 'Data kerusakan tidak valid');
                return $this->redirect();
            }
            $crashCar = "Iya";
        }
        $dtPinjam = $this->ModelPinjam->find($this->request->getPost('id_pinjam'));
        if (empty($dtPinjam)) {
            session()->setFlashdata('danger', 'Data peminjaman tidak ditemukan');
            return $this->redirect();
        }
        $dtKembali = $this->ModelKembali->where('id_pinjam', $dtPinjam['id_pinjam'])->first();
        if (!empty($dtKembali) || $dtPinjam['status_pinjam'] != "Dipinjam") {
            session()->setFlashdata('danger', 'Data peminjaman telah dikembalikan');
            return $this->redirect();
        }
        $sisaDurasi = (int)((strtotime($dtPinjam['tgl_kembali']) - strtotime(date("Y-m-d H:i:s"))) / 3600);
        if ($sisaDurasi < 0) {
            $dendaKeterlambat = $this->dendaPerjam * $sisaDurasi;
        } else {
            $dendaKeterlambat = 0;
        }
        $data = [
            'id_pinjam' => $dtPinjam['id_pinjam'],
            'tgl_kembali' => date('Y-m-d H:i:s'),
            'kondisi_mobil' => $this->request->getPost('kondisi_mobil'),
            'jml_denda' => $dendaKeterlambat,
            'mobil_rusak' => $crashCar,
            'kerusakan' => $this->request->getPost('kerusakan'),
            'denda_kerusakan' => $this->request->getPost('denda_kerusakan'),
            'created_at' => date("Y-m-d H:i:s")
        ];
        $this->ModelKembali->insert($data);
        $dtKembali = $this->ModelKembali->where('id_pinjam', $dtPinjam['id_pinjam'])->first();
        if (!empty($dtKembali)) {
            $data = [
                'status_pinjam' => 'Kembali'
            ];
            $this->ModelPinjam->update($dtPinjam['id_pinjam'], $data);
            $dtPinjam = $this->ModelPinjam->find($this->request->getPost('id_pinjam'));
            if ($dtPinjam['status_pinjam'] == 'Kembali') {
                if ($crashCar == "Iya") {
                    $kondisi = "Rusak";
                } else {
                    $kondisi = "Ada";
                }
                $data = [
                    'status' => $kondisi
                ];
                $this->ModelMobil->update($dtPinjam['id_mobil'], $data);
                session()->setFlashdata('success', 'Data berhasil disimpan');
            } else {
                $this->ModelKembali->delete($dtKembali['id_kembali']);
                session()->setFlashdata('success', 'Data gagal disimpan');
            }
        }
        return $this->redirect();
    }

    public function changejaminan()
    {
        if (!$this->validate([
            'changeJaminan_id' => 'required|is_natural_no_zero',
            'changeJaminan' => 'required|in_list[KTP,SIM C,Passport,KK,Kendaraan Bermotor,BPKB]'
        ])) {
            session()->setFlashdata('danger', 'Data tidak valid');
            return $this->redirect();
        }
        $dtPeminjaman = $this->ModelPinjam->find($this->request->getPost('changeJaminan_id'));
        if (empty($dtPeminjaman)) {
            session()->setFlashdata('danger', 'Data peminjaman tidak ditemukan');
            return $this->redirect();
        }
        if (!is_null($dtPeminjaman['jaminan'])) {
            session()->setFlashdata('danger', 'Data peminjaman tidak valid');
            return $this->redirect();
        }
        $data = [
            'jaminan' => $this->request->getPost('changeJaminan'),
            'status_pinjam' => 'Dipinjam'
        ];
        $this->ModelPinjam->update($dtPeminjaman['id_pinjam'], $data);
        $dtPeminjaman = $this->ModelPinjam->find($this->request->getPost('changeJaminan_id'));
        if (is_null($dtPeminjaman['jaminan'])) {
            session()->setFlashdata('danger', 'Data peminjaman gagal dirubah. Silahkan coba lagi nanti');
        } else {
            session()->setFlashdata('success', 'Data peminjaman berhasil dirubah');
        }
        return $this->redirect();
    }

    public function addsopir()
    {
        if (!$this->validate([
            'idPinjam' => 'required|is_natural_no_zero',
            'sopirid' => 'required|is_natural_no_zero',
        ])) {
            session()->setFlashdata('danger', 'Data tidak valid');
            return $this->redirect();
        }
        $dtTransaksi = $this->ModelPinjam->find($this->request->getPost('idPinjam'));
        if (empty($dtTransaksi)) {
            session()->setFlashdata('danger', 'Data transaksi tidak ditemukan');
            return $this->redirect();
        }
        if (strtolower($dtTransaksi['sopir']) != "iya" || !is_null($dtTransaksi['id_sopir'])) {
            session()->setFlashdata('danger', 'Data transaksi tidak valid');
            return $this->redirect();
        }
        $dtSopir = $this->ModelSopir->find($this->request->getPost('sopirid'));
        if (empty($dtSopir)) {
            session()->setFlashdata('danger', 'Data sopir tidak ditemukan');
            return $this->redirect();
        }
        $data = ['id_sopir' => $dtSopir['id_sopir']];
        $this->ModelPinjam->update($dtTransaksi['id_pinjam'], $data);
        $dtTransaksi = $this->ModelPinjam->find($this->request->getPost('idPinjam'));
        if (is_null($dtTransaksi['id_sopir'])) {
            session()->setFlashdata('danger', 'Data sopir gagal ditentukan. Silahkan coba lagi nanti.');
            return $this->redirect();
        } else {
            session()->setFlashdata('success', 'Data sopir berhasil ditentukan');
            return $this->redirect();
        }
    }
}
