<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function totalMobil()
    {
        $mobil = new ModelMobil();
        return count($mobil->findAll());
    }

    public function totalSopir()
    {
        $sopir = new ModelSopir();
        return count($sopir->findAll());
    }
}
