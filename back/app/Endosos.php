<?php

namespace App;

use App\Polizas;
use App\TipoEndosos;
use App\DetalleEndosos;
use Illuminate\Database\Eloquent\Model;

class Endosos extends Model
{

    protected $guarded = [];

    public function polizas() {
        return $this->belongsTo(Polizas::class, 'poliza_id');
    }

    public function tipoEndosos() {
        return $this->belongsTo(TipoEndosos::class, 'tipo_endoso_id');
    }

    public function detalleEndosos() {
        return $this->belongsTo(DetalleEndosos::class, 'detalle_endoso_id');
    }
}
