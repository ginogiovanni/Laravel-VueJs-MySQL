<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use Auth;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $personals = Personal::join('comunas','personals.idcomuna','=','comunas.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('personals.id','personals.rut', 'personals.nombre', 'personals.fecha_nac', 'personals.edad', 'personals.direccion', 'personals.idcomuna', 'personals.telefono', 'personals.correo', 'comunas.nombre as nombre_comuna', 'personals.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->orderBy('personals.id', 'desc')
            ->paginate(6);
        }else{
            $personals = Personal::join('comunas','personals.idcomuna','=','comunas.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('personals.id','personals.rut', 'personals.nombre', 'personals.fecha_nac', 'personals.edad', 'personals.direccion', 'personals.idcomuna', 'personals.telefono', 'personals.correo', 'comunas.nombre as nombre_comuna', 'personals.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->where('personals.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('personals.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $personals->total(),
                'current_page'  => $personals->currentPage(),
                'per_page'      => $personals->perPage(),
                'last_page'     => $personals->lastPage(),
                'from'          => $personals->firstItem(),
                'to'            => $personals->lastItem(),
            ],
            'personals' => $personals
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $personal = new Personal();
        $personal->rut = $request->rut;
        $personal->nombre = $request->nombre;
        $personal->fecha_nac = $request->fecha_nac;
        $personal->edad = $request->edad;
        $personal->direccion = $request->direccion;
        $personal->idcomuna = $request->idcomuna;
        $personal->telefono = $request->telefono;
        $personal->correo = $request->correo;
        $personal->condicion = '1';
        $personal->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $personal = Personal::findOrFail($request->id);
        $personal->rut = $request->rut;
        $personal->nombre = $request->nombre;
        $personal->fecha_nac = $request->fecha_nac;
        $personal->edad = $request->edad;
        $personal->direccion = $request->direccion;
        $personal->idcomuna = $request->idcomuna;
        $personal->telefono = $request->telefono;
        $personal->correo = $request->correo;
        $personal->condicion = '1';
        $personal->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $personal = Personal::findOrFail($request->id);
        $personal->condicion = '0';
        $personal->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $personal = Personal::findOrFail($request->id);
        $personal->condicion = '1';
        $personal->save();
    }

    public function selectPersonal(Request $request){
        if(!$request->ajax()) return redirect('/');

        $personals = Personal::select('id', 'rut', 'nombre')->orderBy('nombre', 'asc')->get();

        return ['personals' => $personals];
    }

    public function selectPersonalUser(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $personals = Personal::select('id', 'nombre', 'rut')->whereNotIn('id', function($q){
            $q->select('idpersonal')->from('usuariospersonal')
            ;})
        ->where('nombre', 'like', '%'. $filtro . '%')
        ->orWhere('rut', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['personals' => $personals];
    }

    
    public function selectPersonalEvent(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $currentuserid = Auth::user()->id;

        $personals = Personal::select('personals.id')
            ->join('usuariospersonal','personals.id','=','usuariospersonal.idpersonal')
        ->where('usuariospersonal.iduser',  '=', $currentuserid)
        ->orderBy('nombre', 'asc')->get();

        return ['personals' => $personals];
    }
}
