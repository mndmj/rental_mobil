<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDetailUser;
use App\Models\ModelUser;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;

class APIAccount extends ResourceController
{
    private $ModelUser = null;
    private $ModelDetailUser = null;

    public function __construct()
    {
        $this->ModelUser = new ModelUser();
        $this->ModelDetailUser =  new ModelDetailUser();
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

    public function editprofile()
    {
        if (!$this->validate([
            'id_user' => 'required|is_natural_no_zero',
            'nik' => 'required|numeric|max_length[16]|min_length[16]',
            'nama' => 'required',
            'jk' => 'required|in_list[Laki-laki,Perempuan]',
            'alamat' => 'required',
            'telepon' => 'required|numeric|min_length[8]|max_length[15]',
            'username' => 'required',
            'email' => 'required|valid_email'
        ])) {
            return $this->setFail('Data tidak valid', 400, $this->validator->getErrors());
        }

        $dtUser = $this->ModelUser->join('detail_user', 'user.id_user = detail_user.id_user')
            ->where('user.id_user', $this->request->getPost('id_user'))
            ->first();
        if (empty($dtUser)) {
            return $this->setFail('Data akun tidak ditemukan ' . $this->request->getBody('id_user'));
        }

        if ($dtUser['username'] != $this->request->getPost('username')) {
            if (!$this->validate([
                'username' => 'is_unique[user.username]'
            ])) {
                return $this->setFail('Username telah digunakan akun lain');
            }
        }

        if ($dtUser['email'] != $this->request->getPost('email')) {
            if (!$this->validate([
                'email' => 'is_unique[user.email]'
            ])) {
                return $this->setFail('Email telah digunakan akun lain');
            }
        }

        if ($dtUser['telepon'] != $this->request->getPost('telepon')) {
            if (!$this->validate([
                'telepon' => 'is_unique[detail_user.telepon]'
            ])) {
                return $this->setFail('Telepon telah digunakan akun lain');
            }
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email')
        ];
        if ($this->validate([
            'password' => 'required|min_length[8]|max_length[16]'
        ])) {
            $data['password'] = md5((string)$this->request->getPost('password'));
        }
        if ($this->ModelUser->update($dtUser['id_user'], $data)) {
            $data = [
                'nik' => $this->request->getPost('nik'),
                'nama' => $this->request->getPost('nama'),
                'telepon' => $this->request->getPost('telepon'),
                'alamat' => $this->request->getPost('alamat'),
                'jk' => $this->request->getPost('jk'),
            ];
            if ($this->ModelDetailUser->update($dtUser['id_detail_user'], $data)) {
                return $this->respond([
                    'success' => true,
                    'msg' => 'Data akun anda berhasil dirubah'
                ]);
            } else {
                return $this->setFail('Username, Email, Password berhasil dirubah. Namun data lainnya gagal dirubah');
            }
        }
        return $this->setFail('Data akun gagal diedit. Silahkan coba lagi nanti');
    }
}
