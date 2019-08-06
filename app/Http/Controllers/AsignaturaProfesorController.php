<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AsignaturaProfesor;
use Auth;

class AsignaturaProfesorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $asignaturasprofesores = AsignaturaProfesor::join('asignaturas','asignaturasprofesores.idasignatura','=','asignaturas.id')
            ->join('cursos', 'asignaturasprofesores.idcurso', '=', 'cursos.id')
            ->join('profesores', 'asignaturasprofesores.idprofesor', '=', 'profesores.id')
            ->select('asignaturasprofesores.id', 'asignaturasprofesores.idasignatura', 'asignaturasprofesores.idcurso', 'asignaturasprofesores.idprofesor', 'asignaturasprofesores.dia', 'asignaturasprofesores.hora_inicio', 'asignaturasprofesores.hora_fin', 'asignaturasprofesores.semestre', 'asignaturasprofesores.jefe','asignaturasprofesores.condicion', 'cursos.nombre as nombrecurso', 'cursos.descripcion as descripcioncurso', 'profesores.nombre as nombreprofesor', 'asignaturas.nombre as nombreasignatura')
            ->orderBy('asignaturasprofesores.id', 'desc')
            ->paginate(6);
        }else{
            $asignaturasprofesores = AsignaturaProfesor::join('asignaturas','asignaturasprofesores.idasignatura','=','asignaturas.id')
            ->join('cursos', 'asignaturasprofesores.idcurso', '=', 'cursos.id')
            ->join('profesores', 'asignaturasprofesores.idprofesor', '=', 'profesores.id')
            ->select('asignaturasprofesores.id', 'asignaturasprofesores.idasignatura', 'asignaturasprofesores.idcurso', 'asignaturasprofesores.idprofesor', 'asignaturasprofesores.dia', 'asignaturasprofesores.hora_inicio', 'asignaturasprofesores.hora_fin', 'asignaturasprofesores.semestre', 'asignaturasprofesores.jefe','asignaturasprofesores.condicion', 'cursos.nombre as nombrecurso', 'cursos.descripcion as descripcioncurso', 'profesores.nombre as nombreprofesor', 'asignaturas.nombre as nombreasignatura')
            ->where('asignaturasprofesores.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('asignaturasprofesores.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $asignaturasprofesores->total(),
                'current_page'  => $asignaturasprofesores->currentPage(),
                'per_page'      => $asignaturasprofesores->perPage(),
                'last_page'     => $asignaturasprofesores->lastPage(),
                'from'          => $asignaturasprofesores->firstItem(),
                'to'            => $asignaturasprofesores->lastItem(),
            ],
            'asignaturasprofesores' => $asignaturasprofesores
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $asignaturaprofesor = new AsignaturaProfesor();
        $asignaturaprofesor->idprofesor = $request->idprofesor;
        $asignaturaprofesor->idasignatura = $request->idasignatura;
        $asignaturaprofesor->idcurso = $request->idcurso;
        $asignaturaprofesor->dia = $request->dia;
        $asignaturaprofesor->hora_inicio = $request->hora_inicio;
        $asignaturaprofesor->hora_fin = $request->hora_fin;
        $asignaturaprofesor->semestre = $request->semestre;
        $asignaturaprofesor->jefe = $request->jefe;
        $asignaturaprofesor->condicion = '1';
        $asignaturaprofesor->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $asignaturaprofesor = AsignaturaProfesor::findOrFail($request->id);
        $asignaturaprofesor->idprofesor = $request->idprofesor;
        $asignaturaprofesor->idasignatura = $request->idasignatura;
        $asignaturaprofesor->idcurso = $request->idcurso;
        $asignaturaprofesor->dia = $request->dia;
        $asignaturaprofesor->hora_inicio = $request->hora_inicio;
        $asignaturaprofesor->hora_fin = $request->hora_fin;
        $asignaturaprofesor->semestre = $request->semestre;
        $asignaturaprofesor->jefe = $request->jefe;
        $asignaturaprofesor->condicion = '1';
        $asignaturaprofesor->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $asignaturaprofesor = AsignaturaProfesor::findOrFail($request->id);
        $asignaturaprofesor->condicion = '0';
        $asignaturaprofesor->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $asignaturaprofesor = AsignaturaProfesor::findOrFail($request->id);
        $asignaturaprofesor->condicion = '1';
        $asignaturaprofesor->save();
    }

    public function getAsignaturasProfesor(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $currentuserid = Auth::user()->id;

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $asignaturasprofesores = AsignaturaProfesor::join('asignaturas','asignaturasprofesores.idasignatura','=','asignaturas.id')
            ->join('cursos', 'asignaturasprofesores.idcurso', '=', 'cursos.id')
            ->join('profesores', 'asignaturasprofesores.idprofesor', '=', 'profesores.id')
            ->join('usuariosprofesor','profesores.id','=','usuariosprofesor.idprofesor')
            ->select('asignaturasprofesores.id', 'asignaturasprofesores.idasignatura', 'asignaturasprofesores.idcurso', 'asignaturasprofesores.idprofesor', 'asignaturasprofesores.dia', 'asignaturasprofesores.hora_inicio', 'asignaturasprofesores.hora_fin', 'asignaturasprofesores.semestre','asignaturasprofesores.jefe','asignaturasprofesores.condicion', 'cursos.nombre as nombrecurso', 'cursos.descripcion as descripcioncurso', 'profesores.nombre as nombreprofesor', 'asignaturas.nombre as nombreasignatura')
            ->where('usuariosprofesor.iduser',  '=', $currentuserid)
            ->orderBy('asignaturasprofesores.id', 'desc')
            ->paginate(6);
        }else{
            $asignaturasprofesores = AsignaturaProfesor::join('asignaturas','asignaturasprofesores.idasignatura','=','asignaturas.id')
            ->join('cursos', 'asignaturasprofesores.idcurso', '=', 'cursos.id')
            ->join('profesores', 'asignaturasprofesores.idprofesor', '=', 'profesores.id')
            ->join('usuariosprofesor','profesores.id','=','usuariosprofesor.idprofesor')
            ->select('asignaturasprofesores.id', 'asignaturasprofesores.idasignatura', 'asignaturasprofesores.idcurso', 'asignaturasprofesores.idprofesor', 'asignaturasprofesores.dia', 'asignaturasprofesores.hora_inicio', 'asignaturasprofesores.hora_fin', 'asignaturasprofesores.semestre','asignaturasprofesores.jefe','asignaturasprofesores.condicion', 'cursos.nombre as nombrecurso', 'cursos.descripcion as descripcioncurso', 'profesores.nombre as nombreprofesor', 'asignaturas.nombre as nombreasignatura')
            ->where('usuariosprofesor.iduser',  '=', $currentuserid)
            ->Where('asignaturasprofesores.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('cursos.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $asignaturasprofesores->total(),
                'current_page'  => $asignaturasprofesores->currentPage(),
                'per_page'      => $asignaturasprofesores->perPage(),
                'last_page'     => $asignaturasprofesores->lastPage(),
                'from'          => $asignaturasprofesores->firstItem(),
                'to'            => $asignaturasprofesores->lastItem(),
            ],
            'asignaturasprofesores' => $asignaturasprofesores
        ];
    }
}
