<?php

namespace App\Http\Controllers;

use App\Localidades;
use Illuminate\Http\Request;
use App\Http\Resources\Localidad as LocalidadesResource;

class LocalidadController extends Controller
{
    public function index()
    {
        $localidades = Localidades::all();

        return LocalidadesResource::collection($localidades);
    }
}
