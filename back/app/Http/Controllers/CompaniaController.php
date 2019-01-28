<?php

namespace App\Http\Controllers;

use App\Companias;
use App\Coberturas;
use App\Localidades;
use App\CodigoProductor;
use App\CodigoOrganizador;
use Illuminate\Http\Request;
use App\Http\Resources\Compania as CompaniasResource;


class CompaniaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companias = Companias::all();
        $localidades = Localidades::all();

        return CompaniasResource::collection($companias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companias = Companias::all();
        $localidades = Localidades::all();


        return CompaniasResource::collection($companias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        ]);

        $compania = Companias::create([
            'nombre' => $request->input('nombre'),
            'cuit' => $request->input('cuit'),
            'direccion' => $request->input('direccion'),
            'localidad_id' => $request->input('localidad_id'),
            'telefono_1' => $request->input('telefono_1'),
            'telefono_aux' => $request->input('telefono_aux'),
            'telefono_siniestros' => $request->input('telefono_siniestros'),
            'codigo_lr' => $request->input('codigo_lr'),
            'email_emision' => $request->input('email_emision'),
            'email_siniestros' => $request->input('email_siniestros'),
            'activo' => $request->input('activo'),
            'color' => $request->input('color'),
            // 'logo' => $request->input('logo'),
        ]);

        return (['message' => 'guardado']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nombre)
    {
        $compania = Companias::where('nombre', $nombre)->get();
        $codigo_organizador = CodigoOrganizador::all();
        $codigo_productor = CodigoProductor::all();
        
        return new CompaniasResource($compania);

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
        $compania = Companias::find($id);
        $compania->update([
            'nombre' => $request->input('nombre'),
            'cuit' => $request->input('cuit'),
            'direccion' => $request->input('direccion'),
            'localidad_id' => $request->input('localidad_id'),
            'telefono_1' => $request->input('telefono_1'),
            'telefono_aux' => $request->input('telefono_aux'),
            'telefono_siniestros' => $request->input('telefono_siniestros'),
            'codigo_lr' => $request->input('codigo_lr'),
            'email_emision' => $request->input('email_emision'),
            'email_siniestros' => $request->input('email_siniestros'),
            'activo' => $request->input('activo'),
            'color' => $request->input('color'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $compania = Companias::find($id);

        $compania->delete();

        return ['message'=>'Eliminado'];
    }
}
