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
            $this->ModelMobil->select('nama, merk, no_polisi, th_keluaran, bahan_bakar, cc_mobil, warna_mobil,harga_sewa, status')->findAll()
        );
    }
}
