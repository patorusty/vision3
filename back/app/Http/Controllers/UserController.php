<?php

namespace App\Http\Controllers;

use App\Usuarios;
use Illuminate\Http\Request;
use App\Http\Resources\Usuario as UsuariosResource;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuarios::with(['tipo_usuario'])->get();

        return UsuariosResource::collection($usuarios);
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
       
        // ]);

        $usuario = Usuarios::create([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'compania' => $request->input('compania'),
            'tipo_usuario_id' => $request->input('tipo_usuario_id'),
            'activo' => $request->input('activo'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            // 'avatar' => $request->input('avatar'),
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
        $usuarios = Usuarios::findOrFail($id);

        return new UsuariosResource($usuarios);
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
        $usuario = Usuarios::find($id);
        $usuario->update([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'compania' => $request->input('compania'),
            'tipo_usuario_id' => $request->input('tipo_usuario_id'),
            'activo' => $request->input('activo'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            // 'avatar' => $request->input('avatar'),
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
        $usuario = Usuarios::find($id);

        $usuario->delete();

        return ['message'=>'Eliminado'];
    }
}
