<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKembali;
use App\Models\ModelMobil;
use App\Models\ModelPinjam;
use CodeIgniter\Exceptions\PageNotFoundException;

class Transaksi extends BaseController
{
    private $ModelPinjam = null;
    private $ModelKembali = null;
    private $ModelMobil = null;

    public function __construct()
    {
        $this->ModelPinjam = new ModelPinjam();
        $this->ModelKembali = new ModelKembali();
        $this->ModelMobil = new ModelMobil();
    }

    public function index()
    {
        return throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // PINJAM
    public function pinjam()
    {
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Peminjaman',
            'pinjam' => $this->ModelPinjam
                ->select('*, detail_user.nama as nama_user, mobil.nama as nama_mobil, detail_user.telepon as telepon_user, sopir.telepon as telepon_sopir')
                ->join('user', 'user.id_user = transaksi_pinjam.id_user', 'left')
                ->join('detail_user', 'detail_user.id_user = user.id_user', 'left')
                ->join('mobil', 'mobil.id_mobil = transaksi_pinjam.id_mobil')
                ->join('sopir', 'sopir.id_sopir = transaksi_pinjam.id_sopir', 'left')
                ->findAll(),
            'mobil' => $this->ModelMobil->where('status', 'Ada')->findAll(),
            'jaminan' => $this->jaminan,
        ];
        return view('admin/view_pinjam.php', $data);
    }

    public function detail_pinjam()
    {
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Detail Peminjaman',
        ];
        return view('admin/view_detail_pinjam', $data);
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
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Pengembalian',
            'kembali' => $this->ModelKembali
                ->join('transaksi_pinjam', 'transaksi_pinjam.id_pinjam = transaksi_kembali.id_pinjam')
                ->findAll(),
            'mobil' => $this->ModelMobil->where('status', 'Ada')->findAll(),
        ];
        return view('admin/view_kembali.php', $data);
    }

    public function detail_kembali()
    {
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Detail Pengembalian',
        ];
        return view('admin/view_detail_kembali', $data);
    }
}
