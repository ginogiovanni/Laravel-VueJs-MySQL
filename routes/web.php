<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=> ['guest']],function(){
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=> ['auth']],function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

     Route::group(['middleware'=> ['Personal']],function(){
        
        /*  
        | Routes AsignaturaController
        */
        route::get('/asignatura', 'AsignaturaController@index');
        route::post('/asignatura/registrar', 'AsignaturaController@store');
        route::put('/asignatura/modificar', 'AsignaturaController@update');
        route::put('/asignatura/desactivar', 'AsignaturaController@desactivar');
        route::put('/asignatura/activar', 'AsignaturaController@activar');

        /*
        | Routes CursoController
        */
        route::get('/curso', 'CursoController@index');
        route::post('/curso/registrar', 'CursoController@store');
        route::put('/curso/modificar', 'CursoController@update');
        route::put('/curso/desactivar', 'CursoController@desactivar');
        route::put('/curso/activar', 'CursoController@activar');

        /*
        | Routes PersonalController
        */
        route::get('/personal', 'PersonalController@index');
        route::post('/personal/registrar', 'PersonalController@store');
        route::put('/personal/modificar', 'PersonalController@update');
        route::put('/personal/desactivar', 'PersonalController@desactivar');
        route::put('/personal/activar', 'PersonalController@activar');

        /*
        | Routes ComunaController, ProvinciaController, RegionController
        */
        route::get('/comuna/selectComuna', 'ComunaController@selectComuna');
        route::get('/provincia/selectProvincia', 'ProvinciaController@selectProvincia');
        route::get('/region/selectRegion', 'RegionController@selectRegion');
        route::get('/curso/selectCurso', 'CursoController@selectCurso');
        route::get('/apoderado/selectApoderado', 'ApoderadoController@selectApoderado');
        route::get('/apoderado/selectApoderadoUser', 'ApoderadoController@selectApoderadoUser');
        route::get('/profesor/selectProfesor', 'ProfesorController@selectProfesor');
        route::get('/profesor/selectProfesorUser', 'ProfesorController@selectProfesorUser');
        route::get('/asignatura/selectAsignatura', 'AsignaturaController@selectAsignatura');
        route::get('/personal/selectPersonal', 'PersonalController@selectPersonal');
        route::get('/alumno/selectAlumno', 'AlumnoController@selectAlumno');
        route::get('/personal/selectPersonalUser', 'PersonalController@selectPersonalUser');
        route::get('/personal/selectPersonalEvent', 'PersonalController@selectPersonalEvent');
        route::get('/asignatura/selectAsignaturaNo', 'AsignaturaController@selectAsignaturaNo');

        /*
        | Routes ProfesorController
        */
        route::get('/profesor', 'ProfesorController@index');
        route::post('/profesor/registrar', 'ProfesorController@store');
        route::put('/profesor/modificar', 'ProfesorController@update');
        route::put('/profesor/desactivar', 'ProfesorController@desactivar');
        route::put('/profesor/activar', 'ProfesorController@activar');

        /*
        | Routes ApoderadoController
        */
        route::get('/apoderado', 'ApoderadoController@index');
        route::post('/apoderado/registrar', 'ApoderadoController@store');
        route::put('/apoderado/modificar', 'ApoderadoController@update');
        route::put('/apoderado/desactivar', 'ApoderadoController@desactivar');
        route::put('/apoderado/activar', 'ApoderadoController@activar');


        /*
        | Routes AlumnoController
        */
        route::get('/alumno', 'AlumnoController@index');
        route::post('/alumno/registrar', 'AlumnoController@store');
        route::put('/alumno/modificar', 'AlumnoController@update');
        route::put('/alumno/desactivar', 'AlumnoController@desactivar');
        route::put('/alumno/activar', 'AlumnoController@activar');


        /*
        | Routes AsignaturaProfesorController
        */
        route::get('/asignaturaprofesor', 'AsignaturaProfesorController@index');
        route::post('/asignaturaprofesor/registrar', 'AsignaturaProfesorController@store');
        route::put('/asignaturaprofesor/modificar', 'AsignaturaProfesorController@update');
        route::put('/asignaturaprofesor/desactivar', 'AsignaturaProfesorController@desactivar');
        route::put('/asignaturaprofesor/activar', 'AsignaturaProfesorController@activar');


        /*
        | Routes RolController
        */
        route::get('/rol', 'RolController@index');
        route::get('/rol/selectRol', 'RolController@selectRol');


        /*
        | Routes UserPersonalController
        */
        route::get('/userpersonal', 'UserPersonalController@index');
        route::post('/userpersonal/registrar', 'UserPersonalController@store');
        route::put('/userpersonal/modificar', 'UserPersonalController@update');
        route::put('/userpersonal/desactivar', 'UserPersonalController@desactivar');
        route::put('/userpersonal/activar', 'UserPersonalController@activar');

        /*
        | Routes UserProfesorController
        */
        route::get('/userprofesor', 'UserProfesorController@index');
        route::post('/userprofesor/registrar', 'UserProfesorController@store');
        route::put('/userprofesor/modificar', 'UserProfesorController@update');
        route::put('/userprofesor/desactivar', 'UserProfesorController@desactivar');
        route::put('/userprofesor/activar', 'UserProfesorController@activar');

        /*
        | Routes UserApoderadoController
        */
        route::get('/userapoderado', 'UserApoderadoController@index');
        route::post('/userapoderado/registrar', 'UserApoderadoController@store');
        route::put('/userapoderado/modificar', 'UserApoderadoController@update');
        route::put('/userapoderado/desactivar', 'UserApoderadoController@desactivar');
        route::put('/userapoderado/activar', 'UserApoderadoController@activar');

        route::get('/cursosasignaturas', 'CursoAsignaturaController@index');
        route::post('/cursosasignaturas/registrar', 'CursoAsignaturaController@store');
        route::get('/cursosasignaturas/validarCursosAsignaturas', 'CursoAsignaturaController@validarCursosAsignaturas');

        /*
        | Routes EventoController
        */
        route::get('/evento', 'EventoController@index');
        route::post('/evento/registrar', 'EventoController@store');
        route::put('/evento/modificar', 'EventoController@update');
        route::put('/evento/desactivar', 'EventoController@desactivar');
        route::put('/evento/activar', 'EventoController@activar');

        route::get('/notas/report', 'NotaController@getNotasReport');
        route::get('/comucursos/report', 'ComunicacionCursoController@getComunicacionesCursoReport');
        route::get('/comupod/report', 'ComunicacionApoderadoController@getComunicacionesReportApod');

    });
    
    Route::group(['middleware'=> ['Profesor']],function(){
        //prof

        
        route::get('/getasignaturaprofesor', 'AsignaturaProfesorController@getAsignaturasProfesor');
        route::put('/cursosasignaturas/modificar', 'CursoAsignaturaController@update');        
        route::get('/alumno/porcurso', 'AlumnoController@alumnosPorCurso');
        route::get('/comunicacionesapoderados', 'ComunicacionApoderadoController@index');
        route::post('/comunicacionesapoderados/registrar', 'ComunicacionApoderadoController@store');
        route::put('/comunicacionesapoderados/modificar', 'ComunicacionApoderadoController@update');
        route::put('/comunicacionesapoderados/activar', 'ComunicacionApoderadoController@activar');
        route::put('/comunicacionesapoderados/desactivar', 'ComunicacionApoderadoController@desactivar');
        route::get('/comunicacionescursos', 'ComunicacionCursoController@index');
        route::post('/comunicacionescursos/registrar', 'ComunicacionCursoController@store');
        route::put('/comunicacionescursos/modificar', 'ComunicacionCursoController@update');
        route::put('/comunicacionescursos/activar', 'ComunicacionCursoController@activar');
        route::put('/comunicacionescursos/desactivar', 'ComunicacionCursoController@desactivar');


    });
});


//Route::get('/home', 'HomeController@index')->name('home');
