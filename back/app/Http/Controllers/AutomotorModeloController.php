<?php

namespace App\Http\Controllers;

use App\AutomotorModelo;
use Illuminate\Http\Request;
use App\Http\Resources\AutomotorModelo as AutomotorModelosResource;

class AutomotorModeloController extends Controller
{
    public function index()
    {
        $automotor_modelo = AutomotorModelo::all();

        return AutomotorModelosResource::collection($automotor_modelo);
    }
    public function show($id)
    {
        $automotor_modelo = AutomotorModelo::findOrFail($id);

        return new AutomotorModelosResource($automotor_modelo);
    }
    public function store(Request $request)
    {
        $this->validate($request, []);

        $automotor_modelo = AutomotorModelo::create([
            'automotor_marca_id' => $request->input('automotor_marca_id'),
            'nombre' => $request->input('nombre'),
        ]);

        return (['message' => 'guardado']);
    }

    public function update(Request $request, $id)
    {
        $automotor_modelo = AutomotorModelo::find($id);
        $automotor_modelo->update([
            'automotor_marca_id' => $request->input('automotor_marca_id'),
            'nombre' => $request->input('nombre'),
        ]);
    }
    public function destroy($id)
    {
        $automotor_modelo = AutomotorModelo::find($id);

        $automotor_modelo->delete();

        return ['message' => 'Eliminado'];
    }
}
