<?php

namespace App;

use App\Anio;
use App\AutomotorVersion;
use Illuminate\Database\Eloquent\Model;

class AutomotorAnio extends Model
{
    protected $guarded = [];

    public function automotor_versiones() {
       return $this->belongsTo(AutomotorVersion::class, 'automotor_version_id');
    }
    public function anios() {
        return $this->belongsTo(Anio::class, 'anio_id');
     }
}
