<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Resource('/clientes', 'ClienteController');
Route::Resource('/administracion/companias', 'CompaniaController');
Route::Resource('/administracion/organizadores', 'OrganizadorController');
Route::Resource('/administracion/productores', 'ProductorController');
Route::Resource('/localidades', 'LocalidadController');
Route::Resource('/codigoorganizador', 'CodigoOrganizadorController');
Route::Resource('/codigoproductor', 'CodigoProductorController');
Route::Resource('/cobertura', 'CoberturaController');
Route::Resource('/tiporiesgo', 'TipoRiesgoController');
Route::Resource('/tipovigencia', 'TipoVigenciaController');
Route::Resource('/polizas', 'PolizaController');
Route::get('/numerosolicitud', 'PolizaController@numeroDeSolicitud');
Route::get('/codigoorganizador/compania/{id}', 'CodigoOrganizadorController@indexFiltrado');
Route::get('/codigoproductor/compania/{id}', 'CodigoProductorController@indexFiltrado');
Route::get('/cobertura/compania/{id}', 'CoberturaController@indexFiltrado');
Route::get('/companias/busquedaCuit', 'CompaniaController@search');
Route::get('/organizadores/busquedaCuit', 'OrganizadorController@searchCuit');
Route::get('/organizadores/busquedaMatricula', 'OrganizadorController@searchMatricula');
Route::get('/productores/busquedaCuit', 'OrganizadorController@searchCuit');
Route::get('/productores/busquedaMatricula', 'OrganizadorController@searchMatricula');