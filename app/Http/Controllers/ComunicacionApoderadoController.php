<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ComunicacionApoderado;
use Auth;

class ComunicacionApoderadoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $currentuserid = Auth::user()->id;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $comunicaciones = ComunicacionApoderado::join('profesores', 'comunicacionesapoderados.idprofesor', '=', 'profesores.id')
            ->join('apoderados','comunicacionesapoderados.idapoderado','=','apoderados.id')
            ->join('usuariosprofesor', 'comunicacionesapoderados.idprofesor', '=', 'usuariosprofesor.idprofesor')
            ->select('comunicacionesapoderados.id', 'comunicacionesapoderados.titulo', 'comunicacionesapoderados.estado','comunicacionesapoderados.mensaje' , 'comunicacionesapoderados.created_at' ,'comunicacionesapoderados.leido', 'comunicacionesapoderados.idapoderado', 'comunicacionesapoderados.idprofesor', 'profesores.nombre as nombreprofesor','apoderados.nombre as nombreapoderado')
            ->where('usuariosprofesor.iduser',  '=', $currentuserid)
            ->orderBy('comunicacionesapoderados.id', 'desc')->paginate(6);
        }else{
            $comunicaciones = ComunicacionApoderado::join('profesores', 'comunicacionesapoderados.idprofesor', '=', 'profesores.id')
            ->join('apoderados','comunicacionesapoderados.idapoderado','=','apoderados.id')
            ->join('usuariosprofesor', 'comunicacionesapoderados.idprofesor', '=', 'usuariosprofesor.idprofesor')
            ->select('comunicacionesapoderados.id', 'comunicacionesapoderados.titulo', 'comunicacionesapoderados.mensaje', 'comunicacionesapoderados.estado', 'comunicacionesapoderados.created_at' , 'comunicacionesapoderados.leido', 'comunicacionesapoderados.idapoderado', 'comunicacionesapoderados.idprofesor', 'profesores.nombre as nombreprofesor','apoderados.nombre as nombreapoderado')
            ->where('apoderados.'.$criterio , 'like' , '%' . $buscar . '%')
            ->where('usuariosprofesor.iduser',  '=', $currentuserid)
            ->orderBy('comunicacionesapoderados.id', 'desc')->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $comunicaciones->total(),
                'current_page'  => $comunicaciones->currentPage(),
                'per_page'      => $comunicaciones->perPage(),
                'last_page'     => $comunicaciones->lastPage(),
                'from'          => $comunicaciones->firstItem(),
                'to'            => $comunicaciones->lastItem(),
            ],
            'comunicaciones' => $comunicaciones
        ];
    }

    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comunicaciones = new ComunicacionApoderado();
        $comunicaciones->titulo = $request->titulo;
        $comunicaciones->mensaje = $request->mensaje;
        $comunicaciones->idapoderado = $request->idapoderado;
        $comunicaciones->idprofesor = $request->idprofesor;
        $comunicaciones->estado = '1';
        $comunicaciones->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comunicaciones = ComunicacionApoderado::findOrFail($request->id);
        $comunicaciones->titulo = $request->titulo;
        $comunicaciones->mensaje = $request->mensaje;
        $comunicaciones->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comunicaciones = ComunicacionApoderado::findOrFail($request->id);
        $comunicaciones->estado = '0';
        $comunicaciones->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comunicaciones = ComunicacionApoderado::findOrFail($request->id);
        $comunicaciones->estado = '1';
        $comunicaciones->save();
    }

    public function getComunicaciones($idapod){
        $comunicaciones = ComunicacionApoderado::join('apoderados','comunicacionesapoderados.idapoderado','=','apoderados.id')
            ->join('usuariosapoderados','apoderados.id','=','usuariosapoderados.idapoderado')
            ->join('profesores', 'comunicacionesapoderados.idprofesor', '=', 'profesores.id')
            ->select('comunicacionesapoderados.id', 'comunicacionesapoderados.titulo', 'comunicacionesapoderados.mensaje', 'comunicacionesapoderados.created_at', 'profesores.nombre')
            ->where('usuariosapoderados.iduser',  '=', $idapod)
            ->orderBy('comunicacionesapoderados.id', 'desc')->get();

        return $comunicaciones;
    }

    public function getComunicacionesReportApod(Request $request){

        $buscar = $request->buscar;

        $comunicaciones = ComunicacionApoderado::join('apoderados','comunicacionesapoderados.idapoderado','=','apoderados.id')
            ->join('profesores', 'comunicacionesapoderados.idprofesor', '=', 'profesores.id')
            ->select('comunicacionesapoderados.id', 'comunicacionesapoderados.titulo', 'comunicacionesapoderados.estado' ,'comunicacionesapoderados.mensaje', 'comunicacionesapoderados.created_at', 'profesores.nombre', 'apoderados.rut')
            ->where('apoderados.id',  '=', $buscar)
            ->orderBy('comunicacionesapoderados.id', 'desc')->paginate(6);

        return [
                'pagination' => [
                    'total'         => $comunicaciones->total(),
                    'current_page'  => $comunicaciones->currentPage(),
                    'per_page'      => $comunicaciones->perPage(),
                    'last_page'     => $comunicaciones->lastPage(),
                    'from'          => $comunicaciones->firstItem(),
                    'to'            => $comunicaciones->lastItem(),
                ],
                'comunicaciones' => $comunicaciones
            ];
    }

}
