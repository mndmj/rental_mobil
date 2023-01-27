<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Mobil extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'RentCar',
            'subtitle' => 'Data Mobil',
            // 'mobil' => $this->db->table('tbl_mobil'),
        ];
        return view('admin/view_mobil', $data);
    }
}
