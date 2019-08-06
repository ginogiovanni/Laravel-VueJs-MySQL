<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apoderado;

class ApoderadoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $apoderados = Apoderado::join('comunas','apoderados.idcomuna','=','comunas.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('apoderados.id','apoderados.rut', 'apoderados.nombre', 'apoderados.fecha_nac', 'apoderados.edad', 'apoderados.direccion', 'apoderados.idcomuna', 'apoderados.telefono', 'apoderados.correo', 'comunas.nombre as nombre_comuna', 'apoderados.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->orderBy('apoderados.id', 'desc')
            ->paginate(6);
        }else{
            $apoderados = Apoderado::join('comunas','apoderados.idcomuna','=','comunas.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('apoderados.id','apoderados.rut', 'apoderados.nombre', 'apoderados.fecha_nac', 'apoderados.edad', 'apoderados.direccion', 'apoderados.idcomuna', 'apoderados.telefono', 'apoderados.correo', 'comunas.nombre as nombre_comuna', 'apoderados.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->where('apoderados.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('apoderados.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $apoderados->total(),
                'current_page'  => $apoderados->currentPage(),
                'per_page'      => $apoderados->perPage(),
                'last_page'     => $apoderados->lastPage(),
                'from'          => $apoderados->firstItem(),
                'to'            => $apoderados->lastItem(),
            ],
            'apoderados' => $apoderados
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $apoderado = new Apoderado();
        $apoderado->rut = $request->rut;
        $apoderado->nombre = $request->nombre;
        $apoderado->fecha_nac = $request->fecha_nac;
        $apoderado->edad = $request->edad;
        $apoderado->direccion = $request->direccion;
        $apoderado->idcomuna = $request->idcomuna;
        $apoderado->telefono = $request->telefono;
        $apoderado->correo = $request->correo;
        $apoderado->condicion = '1';
        $apoderado->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $apoderado = Apoderado::findOrFail($request->id);
        $apoderado->rut = $request->rut;
        $apoderado->nombre = $request->nombre;
        $apoderado->fecha_nac = $request->fecha_nac;
        $apoderado->edad = $request->edad;
        $apoderado->direccion = $request->direccion;
        $apoderado->idcomuna = $request->idcomuna;
        $apoderado->telefono = $request->telefono;
        $apoderado->correo = $request->correo;
        $apoderado->condicion = '1';
        $apoderado->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $apoderado = Apoderado::findOrFail($request->id);
        $apoderado->condicion = '0';
        $apoderado->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $apoderado = Apoderado::findOrFail($request->id);
        $apoderado->condicion = '1';
        $apoderado->save();
    }

    
    public function selectApoderado(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $apoderados = Apoderado::select('id', 'nombre', 'rut')
        ->where('rut', 'like', '%'. $filtro . '%')
        ->orWhere('nombre', 'like', '%'. $filtro . '%')
        ->orWhere('id', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['apoderados' => $apoderados];
    }

    public function selectApoderadoUser(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $apoderados = Apoderado::select('id', 'nombre', 'rut')->whereNotIn('id', function($q){
            $q->select('idapoderado')->from('usuariosapoderados')
            ;})
        ->where('nombre', 'like', '%'. $filtro . '%')
        ->orWhere('rut', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['apoderados' => $apoderados];
    }
}
