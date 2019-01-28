<?php

namespace App;

use App\Coberturas;
use App\Localidades;
use App\CodigoProductor;
use App\CodigoOrganizador;
use Illuminate\Database\Eloquent\Model;

class Companias extends Model
{
    protected $guarded = [];


    public function localidades() {
        return $this->belongsTo(Localidades::class, 'localidad_id');
        
    }

    public function codigo_productor()
    {
    return $this->hasMany(CodigoProductor::class, 'compania_id', 'id');
    }

    public function codigo_organizador()
    {
    return $this->hasMany(CodigoOrganizador::class, 'compania_id', 'id');
    }

    public function coberturas()
    {
    return $this->hasMany(Coberturas::class, 'compania_id', 'id');
    }

    public function polizas()
    {
    return $this->hasMany(Polizas::class, 'compania_id', 'id');
    }
}
