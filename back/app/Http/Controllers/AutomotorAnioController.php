<?php

namespace App\Http\Controllers;

use App\AutomotorAnio;
use Illuminate\Http\Request;
use App\Http\Resources\AutomotorAnio as AutomotorAniosResource;

class AutomotorAnioController extends Controller
{
    public function index()
    {
        $automotor_anio = AutomotorAnio::all();

        return AutomotorAniosResource::collection($automotor_anio);
    }
    public function show($id)
    {
        $automotor_anio = AutomotorAnio::findOrFail($id);

        return new AutomotorAniosResource($automotor_anio);
    }
    public function store(Request $request)
    {
        $this->validate($request, []);

        $automotor_anio = AutomotorAnio::create([
            'automotor_version_id' => $request->input('automotor_version_id'),
            'anio' => $request->input('anio'),
        ]);

        return (['message' => 'guardado']);
    }

    public function update(Request $request, $id)
    {
        $automotor_anio = AutomotorAnio::find($id);
        $automotor_anio->update([
            'automotor_version_id' => $request->input('automotor_version_id'),
            'anio' => $request->input('anio'),
        ]);
    }
    public function destroy($id)
    {
        $automotor_anio = AutomotorAnio::find($id);

        $automotor_anio->delete();

        return ['message' => 'Eliminado'];
    }
}
