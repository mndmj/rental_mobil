<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAuth;

class Auth extends BaseController
{
    private $ModelAuth = null;

    public function __construct()
    {
        $this->ModelAuth = new ModelAuth();
        helper('form');
        helper('text');
    }

    public function cek_login()
    {
        $valid = $this->validate([
            'username' => ['rules' => 'required'],
            'password' => ['rules' => 'required|min_length[8]'],
        ]);
        if (!$valid) {
            // Jika data tidak valid
            session()->setFlashdata('errors', $this->validator);
            return redirect()->to(base_url('/'));
        } else {
            // Jika data valid
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $cek_login = $this->ModelAuth->login($username, $password);
            $dtUser = $this->ModelAuth->getDataLogin($username, $password);
            if ($cek_login) {
                $data = [
                    'id_user' =>  $dtUser[0]['id_user'],
                ];
                session()->set('data_user', $data);
                return redirect()->to(base_url('admin'));
            } else {
                session()->setFlashdata('danger', 'Username atau Password salah..!!');
                return redirect()->to(base_url('/'));
            }
        }
    }

    public function logout()
    {
        session()->remove('data_user');
        session()->setFlashdata('success', 'Logout berhasil.');
        return redirect()->to(base_url('/'));
    }
}
