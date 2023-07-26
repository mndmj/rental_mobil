<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMobil;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;

class APIMobil extends ResourceController
{
    private $ModelMobil = null;

    public function __construct()
    {
        $this->ModelMobil = new ModelMobil();
    }

    public function index()
    {
        throw PageNotFoundException::forPageNotFound();
    }

    public function getall()
    {
        return $this->respond(
            $this->ModelMobil->select('id_mobil, nama as nama_mobil, merk, no_polisi, foto_mobil, th_keluaran, bahan_bakar, cc_mobil, warna_mobil,harga_sewa, status')->findAll()
        );
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
        return $this->respond($dtMobil);
    }
}
