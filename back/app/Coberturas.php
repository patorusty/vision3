<?php

namespace App;

use App\Companias;
use Illuminate\Database\Eloquent\Model;

class Coberturas extends Model
{
    protected $guarded = [];


    public function companias() {
        return $this->belongsTo(Companias::class, 'compania_id');
    }
}
