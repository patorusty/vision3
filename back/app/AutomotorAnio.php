<?php

namespace App;

use App\AutomotorVersion;
use Illuminate\Database\Eloquent\Model;

class AutomotorAnio extends Model
{
    protected $guarded = [];

    public function automotor_versiones() {
       return $this->belongsTo(AutomotorVersion::class, 'automotor_version_id');
    }
}
