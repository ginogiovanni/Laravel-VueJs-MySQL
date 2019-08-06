<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;    
use App\Curso;
use App\Asignatura;
use App\Nota;
use App\Alumno;

class CursoAsignaturaController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $cursosasignaturas = Nota::join('alumnos', 'notas.idalumno', '=', 'alumnos.id')
            ->join('asignaturas','notas.idasignatura','=','asignaturas.id')
            ->join('cursos', 'alumnos.idcurso', '=', 'cursos.id')
            ->select('notas.id', 'notas.condicion' ,'alumnos.idcurso', 'cursos.nombre', 'cursos.descripcion', 'alumnos.id as idalumno','alumnos.nombre as nombrealumno', 'notas.id as idnotas', 'notas.semestre', 'asignaturas.id as idasignatura', 'asignaturas.nombre as nombreasignatura')
            ->orderBy('cursos.id', 'desc')->paginate(6);
        }else{
            $cursosasignaturas = Alumno::join('cursos','alumnos.idcurso','=','cursos.id')
            ->join('notas', 'alumnos.id', '=', 'notas.idalumno')
            ->join('asignaturas', 'notas.idasignatura', '=', 'asignaturas.id')
            ->select('notas.id', 'notas.condicion', 'alumnos.idcurso', 'cursos.nombre', 'cursos.descripcion', 'alumnos.id as idalumno','alumnos.nombre as nombrealumno' , 'notas.id as idnotas', 'notas.semestre', 'asignaturas.id as idasignatura', 'asignaturas.nombre as nombreasignatura')
            ->where('cursos.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('cursos.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $cursosasignaturas->total(),
                'current_page'  => $cursosasignaturas->currentPage(),
                'per_page'      => $cursosasignaturas->perPage(),
                'last_page'     => $cursosasignaturas->lastPage(),
                'from'          => $cursosasignaturas->firstItem(),
                'to'            => $cursosasignaturas->lastItem(),
            ],
            'cursosasignaturas' => $cursosasignaturas
        ];
    }

    public function store(Request $request)
    {
        
        $idasig = $request->idasignatura;
        $idcurso = $request->idcurso;
        $semestre = $request->semestre;

        
        $alumnos = Alumno::select('id')->where('idcurso', '=', $idcurso)->get();

        foreach ($alumnos as $alumno){
            $notas = new Nota();
            $notas->nota1 = '0.0';
            $notas->nota2 = '0.0';
            $notas->nota3 = '0.0';
            $notas->nota4 = '0.0';
            $notas->nota5 = '0.0';
            $notas->nota6 = '0.0';
            $notas->nota7 = '0.0';
            $notas->nota8 = '0.0';
            $notas->nota9 = '0.0';
            $notas->nota10 = '0.0';
            $notas->nota11 = '0.0';
            $notas->nota12 = '0.0';
            $notas->semestre = $semestre; 
            $notas->condicion = '1';
            $notas->idasignatura = $idasig;
            $notas->idalumno = $alumno->id;
            $notas->save();   
        }
        
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $nota = Nota::findOrFail($request->id);
        $nota->nota1 = $request->nota1;
        $nota->nota2 = $request->nota2;
        $nota->nota3 = $request->nota3;
        $nota->nota4 = $request->nota4;
        $nota->nota5 = $request->nota5;
        $nota->nota6 = $request->nota6;
        $nota->nota7 = $request->nota7;
        $nota->nota8 = $request->nota8;
        $nota->nota9 = $request->nota9;
        $nota->nota10 = $request->nota10;
        $nota->nota11 = $request->nota11;
        $nota->nota12 = $request->nota12;
        $nota->save();
    }

    public function validarCursosAsignaturas(Request $request)
    {
        
        $idasig = $request->idasignatura;
        $idcurso = $request->idcurso;
        $semestre = $request->semestre;

        $resultados = Nota::join('alumnos', 'notas.idalumno', '=', 'alumnos.id')
        ->select('notas.id', 'alumnos.id', 'notas.idasignatura', 'alumnos.idcurso', 'notas.semestre')
        ->where('notas.idasignatura', '=', $idasig)
        ->where('alumnos.idcurso', '=', $idcurso)
        ->where('notas.semestre', '=', $semestre)->get();

        return ['resultados' => $resultados];
    }
}
