<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAdmin;
use App\Models\ModelKembali;
use App\Models\ModelPinjam;

class Admin extends BaseController
{
    private $ModelAdmin = null;
    private $ModelPinjam = null;
    private $ModelKembali = null;

    public function __construct()
    {
        $this->ModelAdmin = new ModelAdmin();
        $this->ModelPinjam = new ModelPinjam();
        $this->ModelKembali = new ModelKembali();
    }

    public function index()
    {
        $data = [
            'mobil' => $this->ModelAdmin->total_mobil('id_mobil'),
            'sopir' => $this->ModelAdmin->total_sopir('id_sopir'),
            'pinjam' => $this->ModelPinjam->findAll(),
            'kembali' => $this->ModelKembali->findAll()
        ];
        return view('admin/view_dashboard', $data);
    }
}
