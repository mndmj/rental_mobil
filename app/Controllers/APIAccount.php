<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;

class APIAccount extends ResourceController
{
    private $ModelUser = null;

    public function __construct()
    {
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        throw PageNotFoundException::forPageNotFound();
    }

    public function get()
    {
        if (!$this->validate([
            'id_user' => 'required|is_natural_no_zero'
        ])) {
            return $this->fail("Data tidak valid");
        }
        $dtUser = $this->ModelUser->select('username, email, nik, nama, telepon, jk, alamat')
            ->join('detail_user', 'detail_user.id_user = user.id_user')
            ->where('user.id_user', $this->request->getPost('id_user'))
            ->where('id_role', '2')->first();
        if (empty($dtUser)) {
            return $this->fail('Data user tidak ditemukan');
        }
        return $this->respond($dtUser);
    }

    public function getbylogin()
    {
        if (!$this->validate([
            'username' => 'required',
            'password' => 'required'
        ])) {
            return $this->fail("Data tidak valid");
        }
        $dtUser = $this->ModelUser->select('user.id_user as id_user, username, email, nik, nama, telepon, jk')
            ->join('detail_user', 'detail_user.id_user = user.id_user')
            ->where('username', $this->request->getPost('username'))
            ->where('password', $this->request->getPost('password'))
            ->where('id_role', '2')
            ->first();
        if (empty($dtUser)) {
            return $this->fail("Data pengguna tidak ditemukan");
        }
        return $this->respond($dtUser);
    }
}
