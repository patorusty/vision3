<?php

namespace App\Http\Controllers;

use App\Endosos;
use App\TipoEndosos;
use App\DetalleEndosos;
use Illuminate\Http\Request;
use App\Http\Resources\Endoso as EndososResource;


class EndosoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    public function indexFiltrado($poliza_id)
    {
        $endosos = Endosos::with(['tipo_endosos', 'detalle_endosos'])->where('poliza_id', $poliza_id)->get();

        return EndososResource::collection($endosos);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        // ]);

        $endoso = Endosos::create([
            'poliza_id' => $request->input('poliza_id'),
            'tipo_endoso_id' => $request->input('tipo_endoso_id'),
            'detalle_endoso_id' => $request->input('detalle_endoso_id'),
            'fecha_pedido' => $request->input('fecha_pedido'),
            'fecha_emision' => $request->input('fecha_emision'),
            'detalle' => $request->input('detalle'),
            'numero_endoso' => $request->input('numero_endoso'),
            'completo' => $request->input('completo'),
        ]);

        return (['message' => 'guardado']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $endoso = Endosos::findOrFail($id);

        return new EndososResource($endoso);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $endoso = Endosos::find($id);
        $endoso->update([
            'poliza_id' => $request->input('poliza_id'),
            'tipo_endoso_id' => $request->input('tipo_endoso_id'),
            'detalle_endoso_id' => $request->input('detalle_endoso_id'),
            'fecha_pedido' => $request->input('fecha_pedido'),
            'fecha_emision' => $request->input('fecha_emision'),
            'detalle' => $request->input('detalle'),
            'numero_endoso' => $request->input('numero_endoso'),
            'completo' => $request->input('completo'),
        ]);
    }

    public function search()
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $endoso = Endosos::find($id);

        $endoso->delete();

        return ['message'=>'Eliminado'];
    }
}
