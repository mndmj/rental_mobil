<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function total_mobil()
    {
        $mobil = new ModelMobil();
        return count($mobil->findAll());
    }

    public function total_sopir()
    {
        $sopir = new ModelSopir();
        return count($sopir->findAll());
    }
}
