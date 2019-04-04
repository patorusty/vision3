<?php

namespace App;

use App\AutomotorModelo;
use App\AutomotorAnios;
use App\AutomotorMarca;
use Illuminate\Database\Eloquent\Model;

class AutomotorVersion extends Model
{
    protected $guarded = [];

    public function automotor_modelo() {
    return $this->belongsTo(AutomotorModelo::class, 'automotor_modelo_id');
    }
    public function automotor_marca() {
        return $this->belongsTo(AutomotorMarca::class, 'automotor_modelo_id');
        }
    public function automotor_anios()
    {
    return $this->hasMany(AutomotorAnios::class, 'automotor_version_id', 'id');
    }
}
