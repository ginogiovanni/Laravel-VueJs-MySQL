<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $profesores = Profesor::join('comunas','profesores.idcomuna','=','comunas.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('profesores.id','profesores.rut', 'profesores.nombre', 'profesores.fecha_nac', 'profesores.edad', 'profesores.direccion', 'profesores.idcomuna', 'profesores.telefono', 'profesores.correo', 'comunas.nombre as nombre_comuna', 'profesores.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->orderBy('profesores.id', 'desc')
            ->paginate(6);
        }else{
            $profesores = Profesor::join('comunas','profesores.idcomuna','=','comunas.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('profesores.id','profesores.rut', 'profesores.nombre', 'profesores.fecha_nac', 'profesores.edad', 'profesores.direccion', 'profesores.idcomuna', 'profesores.telefono', 'profesores.correo', 'comunas.nombre as nombre_comuna', 'profesores.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->where('profesores.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('profesores.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $profesores->total(),
                'current_page'  => $profesores->currentPage(),
                'per_page'      => $profesores->perPage(),
                'last_page'     => $profesores->lastPage(),
                'from'          => $profesores->firstItem(),
                'to'            => $profesores->lastItem(),
            ],
            'profesores' => $profesores
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesor = new Profesor();
        $profesor->rut = $request->rut;
        $profesor->nombre = $request->nombre;
        $profesor->fecha_nac = $request->fecha_nac;
        $profesor->edad = $request->edad;
        $profesor->direccion = $request->direccion;
        $profesor->idcomuna = $request->idcomuna;
        $profesor->telefono = $request->telefono;
        $profesor->correo = $request->correo;
        $profesor->condicion = '1';
        $profesor->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesor = Profesor::findOrFail($request->id);
        $profesor->rut = $request->rut;
        $profesor->nombre = $request->nombre;
        $profesor->fecha_nac = $request->fecha_nac;
        $profesor->edad = $request->edad;
        $profesor->direccion = $request->direccion;
        $profesor->idcomuna = $request->idcomuna;
        $profesor->telefono = $request->telefono;
        $profesor->correo = $request->correo;
        $profesor->condicion = '1';
        $profesor->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesor = Profesor::findOrFail($request->id);
        $profesor->condicion = '0';
        $profesor->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesor = Profesor::findOrFail($request->id);
        $profesor->condicion = '1';
        $profesor->save();
    }

    public function selectProfesor(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $profesores = Profesor::select('id', 'rut','nombre', 'condicion')
        ->where('condicion', '=', '1')
        ->Where('nombre', 'like', '%'. $filtro . '%')
        ->orWhere('rut', 'like', '%'. $filtro . '%')
        ->orWhere('id', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['profesores' => $profesores];
    }

    public function selectProfesorUser(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $profesores = Profesor::select('id', 'nombre', 'rut')->whereNotIn('id', function($q){
            $q->select('idprofesor')->from('usuariosprofesor')
            ;})
        ->where('nombre', 'like', '%'. $filtro . '%')
        ->orWhere('rut', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['profesores' => $profesores];
    }
}
