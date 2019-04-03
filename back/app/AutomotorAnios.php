<?php

namespace App;

use App\AutomotorVersiones;
use Illuminate\Database\Eloquent\Model;

class AutomotorAnios extends Model
{
    protected $guarded = [];

    public function automotor_versiones() {
       return $this->belongsTo(AutomotorVersiones::class, 'automotor_version_id');
    }
}
