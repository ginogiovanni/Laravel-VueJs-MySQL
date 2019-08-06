<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ComunicacionCurso;
use Auth;

class ComunicacionCursoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $currentuserid = Auth::user()->id;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $comunicaciones = ComunicacionCurso::join('profesores', 'comunicacionescursos.idprofesor', '=', 'profesores.id')
            ->join('cursos','comunicacionescursos.idcurso','=','cursos.id')
            ->join('usuariosprofesor', 'comunicacionescursos.idprofesor', '=', 'usuariosprofesor.idprofesor')
            ->select('comunicacionescursos.id', 'comunicacionescursos.titulo', 'comunicacionescursos.estado','comunicacionescursos.mensaje' , 'comunicacionescursos.created_at', 'comunicacionescursos.idprofesor', 'profesores.nombre as nombreprofesor','cursos.nombre', 'cursos.descripcion')
            ->where('usuariosprofesor.iduser',  '=', $currentuserid)
            ->orderBy('comunicacionescursos.id', 'desc')->paginate(6);
        }else{
            
            $comunicaciones = ComunicacionCurso::join('profesores', 'comunicacionescursos.idprofesor', '=', 'profesores.id')
            ->join('cursos','comunicacionescursos.idcurso','=','cursos.id')
            ->join('usuariosprofesor', 'comunicacionescursos.idprofesor', '=', 'usuariosprofesor.idprofesor')
            ->select('comunicacionescursos.id', 'comunicacionescursos.titulo', 'comunicacionescursos.estado','comunicacionescursos.mensaje' , 'comunicacionescursos.created_at', 'comunicacionescursos.idprofesor', 'profesores.nombre as nombreprofesor','cursos.nombre', 'cursos.descripcion')
            ->where('comunicacionescursos.'.$criterio , 'like' , '%' . $buscar . '%')
            ->where('usuariosprofesor.iduser',  '=', $currentuserid)
            ->orderBy('comunicacionescursos.id', 'desc')->paginate(6);
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
        $comunicaciones = new ComunicacionCurso();
        $comunicaciones->titulo = $request->titulo;
        $comunicaciones->mensaje = $request->mensaje;
        $comunicaciones->idprofesor = $request->idprofesor;
        $comunicaciones->idcurso = $request->idcurso;
        $comunicaciones->estado = '1';
        $comunicaciones->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comunicaciones = ComunicacionCurso::findOrFail($request->id);
        $comunicaciones->titulo = $request->titulo;
        $comunicaciones->mensaje = $request->mensaje;
        $comunicaciones->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comunicaciones = ComunicacionCurso::findOrFail($request->id);
        $comunicaciones->estado = '0';
        $comunicaciones->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comunicaciones = ComunicacionCurso::findOrFail($request->id);
        $comunicaciones->estado = '1';
        $comunicaciones->save();
    }

    public function getComunicacionesCurso($idapod){
        $comunicaciones = ComunicacionCurso::join('cursos','comunicacionescursos.idcurso','=','cursos.id')
            ->join('alumnos','cursos.id', '=', 'alumnos.idcurso')
            ->join('apoderados','alumnos.idapoderado','=','apoderados.id')
            ->join('usuariosapoderados','apoderados.id','=','usuariosapoderados.idapoderado')
            ->join('profesores', 'comunicacionescursos.idprofesor', '=', 'profesores.id')
            ->select('comunicacionescursos.id', 'comunicacionescursos.titulo', 'comunicacionescursos.mensaje', 'comunicacionescursos.created_at', 'profesores.nombre', 'cursos.nombre as nombrecurso', 'cursos.descripcion')
            ->where('usuariosapoderados.iduser',  '=', $idapod)
            ->orderBy('comunicacionescursos.id', 'desc')->get();

        return $comunicaciones;
    }


    public function getComunicacionesCursoReport(Request $request){

        $buscar = $request->buscar;

        $comunicaciones = ComunicacionCurso::join('profesores', 'comunicacionescursos.idprofesor', '=', 'profesores.id')
            ->join('cursos','comunicacionescursos.idcurso','=','cursos.id')
            ->select('comunicacionescursos.id', 'comunicacionescursos.titulo', 'comunicacionescursos.estado','comunicacionescursos.mensaje' , 'comunicacionescursos.created_at', 'comunicacionescursos.idprofesor', 'profesores.nombre as nombreprofesor','cursos.nombre', 'cursos.descripcion')
            ->where('comunicacionescursos.idcurso',  '=', $buscar)
            ->orderBy('comunicacionescursos.id', 'desc')->paginate(6);

    

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
