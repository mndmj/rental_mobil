<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMobil;

class Mobil extends BaseController
{
    private $ModelMobil = null;
    private $db = null;

    public function __construct()
    {
        $this->ModelMobil = new ModelMobil();
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
        $data = [
            'nama' => $this->request->getPost('nama'),
            'merk' => $this->request->getPost('merk'),
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

    public function edit_data($id_mobil)
    {
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
        $this->ModelMobil->update($id_mobil, $data);
        return redirect()->to('mobil')->with('warning', 'Data berhasil diedit');
    }

    public function delete_data($id_mobil)
    {
        $data = [
            'id_mobil' => $id_mobil,
        ];
        $this->ModelMobil->delete($data);
        return redirect()->to('mobil')->with('danger', 'Data berhasil dihapus');
    }
}
