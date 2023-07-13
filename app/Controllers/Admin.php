<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAdmin;

class Admin extends BaseController
{
    private $ModelAdmin = null;

    public function __construct()
    {
        $this->ModelAdmin = new ModelAdmin();
    }

    public function index()
    {
        $data = [
            'mobil' => $this->ModelAdmin->total_mobil('id_mobil'),
            'sopir' => $this->ModelAdmin->total_sopir('id_sopir'),
        ];
        return view('admin/view_dashboard', $data);
    }
}
