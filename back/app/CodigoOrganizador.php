<?php

namespace App;

use App\Companias;
use App\Organizadores;
use App\CodigoProductor;
use Illuminate\Database\Eloquent\Model;

class CodigoOrganizador extends Model
{
    protected $guarded = [];


    public function organizadores() {
        return $this->belongsTo(Organizadores::class, 'organizador_id');
        
    }
    public function companias() {
        return $this->belongsTo(Companias::class, 'compania_id');
    }

    public function codigo_productor()
    {
    return $this->hasMany(CodigoProductor::class, 'codigo_organizador_id', 'id');
    }
}
