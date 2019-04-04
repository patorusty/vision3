<?php

namespace App;

use App\AutomotorModelo;
use App\AutomotorVersion;
use Illuminate\Database\Eloquent\Model;

class AutomotorMarca extends Model
{
    protected $guarded = [];

    public function automotor_modelos()
    {
    return $this->hasMany(AutomotorModelo::class, 'automotor_marca_id', 'id');
    }
    
    
}
