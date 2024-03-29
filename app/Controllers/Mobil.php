<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMobil;
use App\Models\ModelPinjam;
use Exception;

class Mobil extends BaseController
{
    private $ModelMobil = null;
    private $ModelTransaksi = null;
    private $db = null;

    public function __construct()
    {
        $this->ModelMobil = new ModelMobil();
        $this->ModelTransaksi = new ModelPinjam();
        $this->db = \config\Database::connect();
        helper('form');
    }
    public function index()
    {
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Data Mobil',
            'mobil' => $this->ModelMobil->findAll(),
        ];
        return view('admin/view_mobil', $data);
    }

    public function insert_data()
    {
        $foto = $this->request->getFile('foto_mobil');
        $nameFoto = $foto->getRandomName();
        $foto->move('img/foto_mobil/', $nameFoto);
        if ($foto->hasMoved()) {
            $data = [
                'nama' => $this->request->getPost('nama'),
                'merk' => $this->request->getPost('merk'),
                'foto_mobil' => $nameFoto,
                'no_polisi' => $this->request->getPost('no_polisi'),
                'th_keluaran' => $this->request->getPost('th_keluaran'),
                'bahan_bakar' => $this->request->getPost('bahan_bakar'),
                'cc_mobil' => $this->request->getPost('cc_mobil'),
                'warna_mobil' => $this->request->getPost('warna_mobil'),
                'harga_sewa' => $this->request->getPost('harga_sewa'),
            ];
            $this->ModelMobil->insert($data);
            return redirect()->to('mobil')->with('success', 'Data berhasil ditambahkan');
        }
        return redirect()->to('mobil')->with('danger', 'Data gagal ditambahkan');
    }

    public function edit_data($id_mobil)
    {
        // Validasi input data (Selain foto)
        if (!$this->validate([
            'nama' => 'required',
            'merk' => 'required',
            'no_polisi' => 'required|alpha_numeric_space',
            'th_keluaran' => 'required|integer|greater_than_equal_to[1980]',
            'bahan_bakar' => 'required',
            'cc_mobil' => 'required|integer|greater_than_equal_to[500]',
            'warna_mobil' => 'required',
            'harga_sewa' => 'required|integer|greater_than_equal_to[1000]',
            'status' => 'required|in_list[Ada,Tidak Ada,Rusak]'
        ])) {
            return redirect()->to('mobil')->with('danger', 'Mohon isi data dengan benar');
        }
        $data = [
            'nama' => $this->request->getPost('nama'),
            'merk' => $this->request->getPost('merk'),
            'no_polisi' => $this->request->getPost('no_polisi'),
            'th_keluaran' => $this->request->getPost('th_keluaran'),
            'bahan_bakar' => $this->request->getPost('bahan_bakar'),
            'cc_mobil' => $this->request->getPost('cc_mobil'),
            'warna_mobil' => $this->request->getPost('warna_mobil'),
            'harga_sewa' => $this->request->getPost('harga_sewa'),
            'status' => $this->request->getPost('status'),
        ];
        // Validasi foto
        $nameFoto = null;
        $isEditFoto = false;
        if ($this->validate([
            'foto_mobil' => 'uploaded[foto_mobil]|mime_in[foto_mobil,image/png,image/jpeg]'
        ])) {
            // Jika foto di upload
            $foto = $this->request->getFile('foto_mobil');
            $nameFoto = $foto->getRandomName();
            $foto->move('img/foto_mobil/', $nameFoto);
            if ($foto->hasMoved()) {
                $dtMobil = $this->ModelMobil->find($id_mobil);
                try {
                    unlink('img/foto_mobil/' . $dtMobil['foto_mobil']);
                } catch (Exception $e) {
                }
                $data['foto_mobil'] = $nameFoto;
                $isEditFoto = true;
            }
        }
        if ($isEditFoto) {
            $fotoMSG = "";
        } else {
            $fotoMSG = " Foto tidak diedit";
        }
        $this->ModelMobil->update($id_mobil, $data);
        return redirect()->to('mobil')->with('warning', 'Data berhasil diedit.' . $fotoMSG);
    }

    public function delete_data($id_mobil)
    {
        $dtMobil = $this->ModelMobil->find($id_mobil);
        try {
            unlink('img/foto_mobil/' . $dtMobil['foto_mobil']);
        } catch (Exception $e) {
        }
        $data = [
            'id_mobil' => $id_mobil,
        ];
        $this->ModelMobil->delete($data);
        return redirect()->to('mobil')->with('danger', 'Data berhasil dihapus');
    }

    public function getfreemobil()
    {
        if ($this->request->isAJAX()) {
            if ($this->validate([
                'tanggal' => 'required|valid_date',
                'durasi' => 'required|integer|greater_than_equal_to[1]'
            ])) {
                $data = [
                    'success' => false,
                    'msg' => 'Data tanggal atau durasi tidak valid',
                    'data' => null
                ];
            } else {
                $tgl = date("Y-m-d H:i:s", strtotime((string)$this->request->getRawInputVar('tanggal')));
                $durasi = $this->request->getRawInputVar('durasi');
                $estimasi = date("Y-m-d H:i:s", strtotime("+$durasi day", strtotime($tgl)));
                $ignoreMobil = $this->ModelTransaksi->join('mobil', 'mobil.id_mobil=transaksi_pinjam.id_mobil')
                    ->where("(tgl_pinjam < '$tgl' AND  '$tgl' < tgl_kembali)")
                    ->orWhere("(tgl_kembali > '$estimasi' AND '$estimasi' > tgl_pinjam)")
                    ->findAll();
                $listIgnore = [];
                foreach ($ignoreMobil as $dt) {
                    if ($dt['status_pinjam'] != "Kembali") {
                        $tmp = [$dt['id_mobil']];
                        $listIgnore = array_merge($listIgnore, $tmp);
                    }
                }
                if (count($ignoreMobil) == 0 || empty($listIgnore)) {
                    $freeMobil = $this->ModelMobil->select("id_mobil, nama, merk, no_polisi, harga_sewa")->where('status <>', 'Rusak')->findAll();
                } else {
                    $freeMobil = $this->ModelMobil->select("id_mobil, nama, merk, no_polisi, harga_sewa")->where('status <>', 'Rusak')->whereNotIn('id_mobil', $listIgnore)->findAll();
                }
                if (count($freeMobil) == 0) {
                    $data = [
                        'success' => false,
                        'msg' => 'Tidak ada mobil yang free pada tanggal tersebut',
                        'data' => null
                    ];
                } else {
                    $data = [
                        'success' => true,
                        'msg' => 'Silahkan pilih mobilnya',
                        'data' => $freeMobil
                    ];
                }
            }
        } else {
            return $this->redirect();
        }
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }
}
