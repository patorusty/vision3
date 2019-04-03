<?php

namespace App;

use App\AutomotorModelos;
use Illuminate\Database\Eloquent\Model;

class AutomotorMarcas extends Model
{
    protected $guarded = [];

    public function automotor_modelos()
    {
    return $this->hasMany(AutomotorModelos::class, 'automotor_marca_id', 'id');
    }
}
