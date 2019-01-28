<?php

namespace App;

use App\CodigoOrganizador;
use Illuminate\Database\Eloquent\Model;

class Organizadores extends Model
{
    protected $fillable = ['nombre', 'apellido', 'cuit', 'matricula', 'email', 'telefono_1', 'telefono_2', "activo"];

    public function codigo_organizador()
    {
    return $this->hasMany(CodigoOrganizador::class, 'organizador_id', 'id');
    }
}
