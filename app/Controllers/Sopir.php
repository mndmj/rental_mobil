<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSopir;

class Sopir extends BaseController
{
    private $ModelSopir = null;
    private $db = null;

    public function __construct()
    {
        $this->ModelSopir = new ModelSopir();
        $this->db = \config\Database::connect();
        helper('form');
    }
    public function index()
    {
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Data Sopir',
            'sopir' => $this->ModelSopir->findAll(),
        ];
        return view('admin/view_sopir', $data);
    }

    public function insert_data()
    {
        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
        ];
        $this->ModelSopir->insert($data);
        return redirect()->to('sopir')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit_data($id_sopir)
    {
        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
        ];
        $this->ModelSopir->update($id_sopir, $data);
        return redirect()->to('sopir')->with('warning', 'Data berhasil diedit');
    }

    public function delete_data($id_sopir)
    {
        $data = [
            'id_sopir' => $id_sopir,
        ];
        $this->ModelSopir->delete($data);
        return redirect()->to('sopir')->with('danger', 'Data berhasil dihapus');
    }
}
