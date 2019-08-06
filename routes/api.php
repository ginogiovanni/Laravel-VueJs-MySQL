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

Route::post('loginMov', 'Auth\LoginController@loginMov');

route::get('/comunicacionesapoderados/{idapod}/comunicacionesapod', 'ComunicacionApoderadoController@getComunicaciones');
route::get('/comunicacionescursos/{idapod}/comunicacionescurso', 'ComunicacionCursoController@getComunicacionesCurso');
route::get('/notas/{idapod}/notasapod', 'NotaController@getNotas');
route::get('/eventos/geteventos', 'EventoController@getEventos');
