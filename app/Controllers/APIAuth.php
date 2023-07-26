<?php

namespace App\Controllers;

use App\Models\ModelDetailUser;
use App\Models\ModelUser;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;

class APIAuth extends ResourceController
{
    private $ModelUser = null;
    private $ModelDetailUser = null;

    public function __construct()
    {
        $this->ModelUser = new ModelUser();
        $this->ModelDetailUser = new ModelDetailUser();
    }

    public function index()
    {
        throw PageNotFoundException::forPageNotFound();
    }

    public function login()
    {
        if (!$this->validate([
            'username' => 'required',
            'password' => 'required'
        ])) {
            $msg = [
                'success' => false,
                'msg' => 'Data tidak valid'
            ];
        } else {
            $dtUser = $this->ModelUser->where('username', $this->request->getPost('username'))
                ->where('password', md5((string)$this->request->getPost('password')))
                ->where('id_role', '2')
                ->first();
            if (empty($dtUser)) {
                $msg = [
                    'success' => false,
                    'msg' => 'Username atau password salah'
                ];
            } else {
                $msg = [
                    'success' => true,
                    'msg' => 'Login berhasil'
                ];
            }
        }
        return $this->respond($msg);
    }

    public function regist()
    {
        if (!$this->validate([
            'username' => 'required|max_length[16]|is_unique[user.username]',
            'password' => 'required|max_length[16]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'nik' => 'required|max_length[16]|numeric|is_unique[detail_user.nik]',
            'nama' => 'required|max_length[30]',
            'telepon' => 'required|max_length[15]|numeric|is_unique[detail_user.telepon]',
            'alamat' => 'required',
            'jk' => 'required|in_list[Laki-laki,Perempuan'
        ])) {
            $msg = [
                'success' => false,
                'msg' => 'Data tidak valid'
            ];
        } else {
            $data = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'),
                'email' => $this->request->getPost('email'),
                'id_role' => '2'
            ];
            $this->ModelUser->insert($data);
            $dtUser = $this->ModelUser->where('username', $this->request->getPost('username'))->first();
            if (empty($dtUser)) {
                $msg = [
                    'success' => false,
                    'msg' => 'Data gagal disimpan. Silahkan coba lagi nanti'
                ];
            } else {
                $data = [
                    'id_user' => $dtUser['id_user'],
                    'nik' => $this->request->getPost('nik'),
                    'nama' => $this->request->getPost('nama'),
                    'telepon' => $this->request->getPost('telepon'),
                    'alamat' => $this->request->getPost('alamat'),
                    'jk' => $this->request->getPost('jk'),
                ];
                $this->ModelDetailUser->insert($data);
                $dtDetail = $this->ModelDetailUser->where('id_user', $dtUser['id_user'])->first();
                if (empty($dtDetail)) {
                    $this->ModelUser->delete($dtUser['id_user']);
                    $msg = [
                        'success' => false,
                        'msg' => 'Biodata gagal disimpan. Silahkan coba lagi nanti'
                    ];
                } else {
                    $msg = [
                        'success' => true,
                        'msg' => 'Registrasi berhasil'
                    ];
                }
            }
        }
        return $this->respond($msg);
    }
}
