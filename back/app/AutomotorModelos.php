<?php

namespace App;

use App\AutomotorVersiones;
use App\AutomotorMarca;
use Illuminate\Database\Eloquent\Model;

class AutomotorModelos extends Model
{
    protected $guarded = [];

    public function automotor_versiones()
    {
    return $this->hasMany(AutomotorVersiones::class, 'automotor_modelo_id', 'id');
    }

    public function automotor_marca() {
        return $this->belongsTo(AutomotorMarca::class, 'marca_id');
     }

}
