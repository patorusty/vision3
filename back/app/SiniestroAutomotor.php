<?php

namespace App;

use App\Polizas;
use Illuminate\Database\Eloquent\Model;

class SiniestroAutomotor extends Model
{
    public function polizas() {
        return $this->belongsTo(Polizas::class, 'poliza_id');
    }
}
