<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAuth extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['username', 'password', 'email'];

    public function get_data_login($username, $password)
    {
        $model_user = new ModelUser();
        return    $model_user
            ->where('username', $username)
            ->where('password', $password)
            ->findAll();
    }

    public function login($username, $password)
    {
        $dt = $this->get_data_login($username, $password);
        if (count($dt) == 1) {
            if ($dt[0]['id_role'] == 1) {
                return true;
            }
        }
        return false;
    }
}
