<?php

namespace App\Http\Controllers;

use App\ImagenRiesgoAutomotor;
use Illuminate\Http\Request;

use App\Http\Resources\ImagenRiesgoAutomotor as ImagenRiesgoAutomotorResource;


class ImagenRiesgoAutomotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function uploadFile(Request $request) {
        
            if($request->file('file'))
            {
               $image = $request->file('file');
            //    $riesgo_id = $request->file('file');
               $size = $image->getClientSize();
               $name = time().$image->getClientOriginalName();
               $path = '/images/'.$name;
               $mime = $image->getClientMimeType();
               $image->move(public_path().'/images/', $name); 
             }
     
            $image= new ImagenRiesgoAutomotor();
            $image->filename = $name;
            $image->path = $path;
            $image->size = $size;
            $image->mime = $mime;
            // $image->riesgo_automotor_id = $riesgo_id;
            $image->save();
     
            return response()->json(['success' => 'You have successfully uploaded an image'], 200);
          
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImagenRiesgoAutomotor  $imagenRiesgoAutomotor
     * @return \Illuminate\Http\Response
     */
    public function show(ImagenRiesgoAutomotor $imagenRiesgoAutomotor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImagenRiesgoAutomotor  $imagenRiesgoAutomotor
     * @return \Illuminate\Http\Response
     */
    public function edit(ImagenRiesgoAutomotor $imagenRiesgoAutomotor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImagenRiesgoAutomotor  $imagenRiesgoAutomotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImagenRiesgoAutomotor $imagenRiesgoAutomotor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImagenRiesgoAutomotor  $imagenRiesgoAutomotor
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImagenRiesgoAutomotor $imagenRiesgoAutomotor)
    {
        //
    }
}
