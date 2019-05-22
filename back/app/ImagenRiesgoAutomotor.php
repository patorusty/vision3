<?php

namespace App;

use App\RiesgoAutomotor;


use Illuminate\Database\Eloquent\Model;

class ImagenRiesgoAutomotor extends Model
{
    protected $fillable = ['filename', 'mime', 'path', 'size'];

    public function riesgo_automotor()
   {
      return $this->hasMany(RiesgoAutomotor::class, 'riesgo_automotor_id');
   }
}
