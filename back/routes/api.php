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
Route::Resource('/administracion/marcas', 'AutomotorMarcaController');
Route::Resource('/administracion/modelos', 'AutomotorModeloController');
Route::Resource('/administracion/versiones', 'AutomotorVersionController');
Route::Resource('/configuracion/usuarios', 'UserController');
Route::Resource('/localidades', 'LocalidadController');
Route::Resource('/anios', 'AnioController');
Route::Resource('/codigoorganizador', 'CodigoOrganizadorController');
Route::Resource('/codigoproductor', 'CodigoProductorController');
Route::Resource('/cobertura', 'CoberturaController');
Route::Resource('/tiporiesgo', 'TipoRiesgoController');
Route::Resource('/tipovigencia', 'TipoVigenciaController');
Route::Resource('/polizas', 'PolizaController');
Route::Resource('/endosos', 'EndosoController');
Route::Resource('/siniestrosautomotor', 'SiniestroAutomotorController');
Route::Resource('/tipoendoso', 'TipoEndosoController');
Route::Resource('/riesgo_automotor', 'RiesgoAutomotorController');
Route::Resource('/notas_siniestro_aut', 'NotaSiniestroAutController');
Route::Resource('/tipousuario', 'TipoUsuarioController');

Route::post('/imagenes_r_a', 'ImagenRAController@uploadFile');
Route::get('/numerosolicitud', 'PolizaController@numeroDeSolicitud');
Route::get('/codigoorganizador/compania/{id}', 'CodigoOrganizadorController@indexFiltrado');
Route::get('/codigoproductor/compania/{id}', 'CodigoProductorController@indexFiltrado');
Route::get('/cobertura/compania/{id}', 'CoberturaController@indexFiltrado');
Route::get('/riesgo_automotores/{id}', 'RiesgoAutomotorController@indexFiltrado');
Route::get('/companias/busquedaCuit', 'CompaniaController@search');
Route::get('/organizadores/busquedaCuit', 'OrganizadorController@searchCuit');
Route::get('/organizadores/busquedaMatricula', 'OrganizadorController@searchMatricula');
Route::get('/productores/busquedaCuit', 'ProductorController@searchCuit');
Route::get('/productores/busquedaMatricula', 'ProductorController@searchMatricula');
Route::get('/poliza/busquedaNumero', 'PolizaController@searchPoliza');
Route::get('/codigo_organizadores/busquedaCO', 'CodigoOrganizadorController@searchCO');
Route::get('/codigo_productores/busquedaCP', 'CodigoProductorController@searchCP');
Route::get('/cliente/busquedaDNI', 'ClienteController@searchDNI');
Route::get('/cliente/busquedaCuit', 'ClienteController@searchCuit');
Route::get('/modelos/filtrar/{id}', 'AutomotorModeloController@filtro');
Route::get('/versiones/filtrar/{id}', 'AutomotorVersionController@filtro');
Route::get('/anios/filtrar/{anio}/{version}', 'AutomotorAnioController@filtro');
Route::get('/anios/filtrar/{id}', 'AutomotorAnioController@filtroXAnio');
Route::get('/marcas/busquedaMarca', 'AutomotorMarcaController@searchMarca');
Route::get('/modelos/busquedaModelo', 'AutomotorModeloController@searchModelo');
Route::get('/versiones/busquedaVersion', 'AutomotorVersionController@searchVersion');
Route::get('/polizas/busquedaPolizaId/{id}', 'RiesgoAutomotorController@searchPoliza');
Route::get('/detallesendosos/filtrar/{id}', 'DetalleEndosoController@filtro');
Route::get('/endosos/poliza_id/{id}', 'EndosoController@indexFiltrado');    
Route::get('/siniestrosautomotor/poliza_id/{id}', 'SiniestroAutomotorController@indexFiltrado');  
Route::get('/notasiniestroautomotor/siniestro_automotor_id/{id}', 'NotaSiniestroAutController@indexFiltrado');  



