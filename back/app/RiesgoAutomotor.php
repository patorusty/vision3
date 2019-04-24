<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiesgoAutomotor extends Model
{
    protected $guarded = [];

    public function polizas() {
        return $this->belongsTo(Polizas::class, 'poliza_id');
     }
}
