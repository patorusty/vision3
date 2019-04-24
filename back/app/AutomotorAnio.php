<?php

namespace App;

use App\AutomotorVersion;
use App\RiesgoAutomotor;
use Illuminate\Database\Eloquent\Model;

class AutomotorAnio extends Model
{
    protected $guarded = [];

    public function automotor_versiones() {
       return $this->belongsTo(AutomotorVersion::class, 'automotor_version_id');
    }
    
    public function riesgo_automotor(){
      return $this->hasMany(RiesgoAutomotor::class, 'automotor_anio_id', 'id');
  }
}
