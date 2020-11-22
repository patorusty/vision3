<?php

namespace App\Http\Controllers;

use App\Productores;
use Illuminate\Http\Request;
use App\Http\Resources\Productor as ProductoresResource;

class ProductorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productores = Productores::all();

        return ProductoresResource::collection($productores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            // 'nombre' => 'required',
            // 'apellido' => 'required',
            // 'cuit' => 'required',
            // 'matricula' => 'required',
            // 'email' => 'required',
            // 'telefono_1' => 'required',
            // 'telefono_2' => 'required',
        // ]);

        $productor = Productores::create([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'cuit' => $request->input('cuit'),
            'matricula' => $request->input('matricula'),
            'email' => $request->input('email'),
            'telefono_1' => $request->input('telefono_1'),
            'telefono_2' => $request->input('telefono_2'),
            'activo' => $request->input('activo'),
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
        $productor = Productores::findOrFail($id);

        return new ProductoresResource($productor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $productor = Productores::find($id);
        $productor->update([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'cuit' => $request->input('cuit'),
            'matricula' => $request->input('matricula'),
            'email' => $request->input('email'),
            'telefono_1' => $request->input('telefono_1'),
            'telefono_2' => $request->input('telefono_2'),
            'activo' => $request->input('activo'),
        ]);
    }
    public function searchCuit()
    {
        if ($search = \Request::get('q')) {
            $cuits = Productores::where(function ($query) use ($search) {
                $query->where('cuit', 'LIKE', "%$search%");
            })->get();
        } else {
            $cuits = 'Algo fallo';
        }
        return ProductoresResource::collection($cuits);
    }

    public function searchMatricula()
    {
        if ($search = \Request::get('q')) {
            $matriculas = Productores::where(function ($query) use ($search) {
                $query->where('matricula', 'LIKE', "%$search%");
            })->get();
        } else {
            $matriculas = 'Algo fallo';
        }
        return ProductoresResource::collection($matriculas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productor = Productores::find($id);

        $productor->delete();

        return ['message'=>'Eliminado'];
    }
}
