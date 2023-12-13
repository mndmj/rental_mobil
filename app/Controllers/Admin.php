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
        $dtKembali = $this->ModelKembali->findAll();
        $ignorePinjam = [];
        foreach ($dtKembali as $dt) {
            array_push($ignorePinjam, $dt['id_pinjam']);
        }
        $data = [
            'mobil' => $this->ModelAdmin->total_mobil('id_mobil'),
            'sopir' => $this->ModelAdmin->total_sopir('id_sopir'),
            'pinjam' => $this->ModelPinjam->whereNotIn('id_pinjam', $ignorePinjam)->findAll(),
            'kembali' => $dtKembali
        ];
        return view('admin/view_dashboard', $data);
    }
}
