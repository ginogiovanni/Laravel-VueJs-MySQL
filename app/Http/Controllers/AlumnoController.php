<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Alumno;
use App\Nota;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $alumnos = Alumno::join('comunas','alumnos.idcomuna','=','comunas.id')
            ->join('cursos','alumnos.idcurso','=','cursos.id')
            ->join('apoderados','alumnos.idapoderado','=','apoderados.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('alumnos.id','alumnos.rut', 'alumnos.nombre', 'alumnos.fecha_nac', 'alumnos.edad', 'alumnos.direccion', 'alumnos.idcomuna', 'alumnos.idapoderado', 'alumnos.idcurso', 'apoderados.nombre as nombre_apoderado', 'apoderados.telefono as telefono_apoderado', 'cursos.nombre as curso_nombre', 'cursos.descripcion as curso_desc', 'comunas.nombre as nombre_comuna', 'alumnos.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->orderBy('alumnos.id', 'desc')
            ->paginate(6);
        }else{
            $alumnos = Alumno::join('comunas','alumnos.idcomuna','=','comunas.id')
            ->join('cursos','alumnos.idcurso','=','cursos.id')
            ->join('apoderados','alumnos.idapoderado','=','apoderados.id')
            ->join('provincias', 'comunas.idprovincia', '=', 'provincias.id')
            ->join('regiones', 'provincias.idregion', '=', 'regiones.id')
            ->select('alumnos.id','alumnos.rut', 'alumnos.nombre', 'alumnos.fecha_nac', 'alumnos.edad', 'alumnos.direccion', 'alumnos.idcomuna', 'alumnos.idapoderado', 'alumnos.idcurso', 'apoderados.nombre as nombre_apoderado', 'apoderados.telefono as telefono_apoderado','cursos.nombre as curso_nombre', 'cursos.descripcion as curso_desc', 'comunas.nombre as nombre_comuna', 'alumnos.condicion', 'provincias.id as idprovincia', 'regiones.id as idregion')
            ->where('alumnos.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('alumnos.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $alumnos->total(),
                'current_page'  => $alumnos->currentPage(),
                'per_page'      => $alumnos->perPage(),
                'last_page'     => $alumnos->lastPage(),
                'from'          => $alumnos->firstItem(),
                'to'            => $alumnos->lastItem(),
            ],
            'alumnos' => $alumnos
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = new Alumno();
        $alumno->rut = $request->rut;
        $alumno->nombre = $request->nombre;
        $alumno->fecha_nac = $request->fecha_nac;
        $alumno->edad = $request->edad;
        $alumno->direccion = $request->direccion;
        $alumno->idcomuna = $request->idcomuna;
        $alumno->idcurso = $request->idcurso;
        $alumno->idapoderado = $request->idapoderado;
        $alumno->condicion = '1';
        $alumno->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->rut = $request->rut;
        $alumno->nombre = $request->nombre;
        $alumno->fecha_nac = $request->fecha_nac;
        $alumno->edad = $request->edad;
        $alumno->direccion = $request->direccion;
        $alumno->idcomuna = $request->idcomuna;
        $alumno->idcurso = $request->idcurso;
        $alumno->idapoderado = $request->idapoderado;
        $alumno->condicion = '1';
        $alumno->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion = '0';
        $alumno->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion = '1';
        $alumno->save();
    }

    public function alumnosPorCurso(Request $request){
        
        $idcurso = $request->idcurso;
        $semestre = $request->semestre;
        $idasignatura = $request->idasignatura;
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $alumnos = Nota::join('alumnos', 'notas.idalumno', '=', 'alumnos.id')
            ->join('apoderados','alumnos.idapoderado','=','apoderados.id')
            ->join('asignaturas','notas.idasignatura','=','asignaturas.id')
            ->join('cursos', 'alumnos.idcurso', '=', 'cursos.id')
            ->join('asignaturasprofesores', 'asignaturas.id', 'asignaturasprofesores.idasignatura')
            ->select('notas.id', 'notas.condicion' ,'alumnos.idcurso', 'asignaturasprofesores.idprofesor','cursos.nombre as curso_nombre', 'cursos.descripcion as curso_desc', 'alumnos.rut', 'alumnos.id as idalumno', 'alumnos.idapoderado','alumnos.nombre', 'apoderados.telefono as telefono_apoderado', 'apoderados.nombre as nombre_apoderado', 'notas.id as idnotas', 'notas.semestre', 'notas.idasignatura', 'asignaturas.nombre as nombreasignatura'
            ,'notas.nota1','notas.nota2','notas.nota3','notas.nota4','notas.nota5','notas.nota6','notas.nota7','notas.nota8','notas.nota9','notas.nota10','notas.nota11','notas.nota12')
            ->where('alumnos.idcurso', '=', $idcurso)
            ->where('asignaturasprofesores.idcurso', '=', $idcurso)
            ->where('notas.idasignatura', '=', $idasignatura)
            ->where('notas.semestre', '=', $semestre)
            ->orderBy('alumnos.id', 'desc')->paginate(6);
            }else{
                $alumnos = Nota::join('alumnos', 'notas.idalumno', '=', 'alumnos.id')
                ->join('apoderados','alumnos.idapoderado','=','apoderados.id')
                ->join('asignaturas','notas.idasignatura','=','asignaturas.id')
                ->join('cursos', 'alumnos.idcurso', '=', 'cursos.id')
                ->join('asignaturasprofesores', 'asignaturas.id', 'asignaturasprofesores.idasignatura')
                ->select('notas.id', 'notas.condicion' ,'alumnos.idcurso','asignaturasprofesores.idprofesor', 'cursos.nombre as curso_nombre', 'cursos.descripcion as curso_desc', 'alumnos.rut', 'alumnos.id as idalumno','alumnos.nombre','alumnos.idapoderado', 'apoderados.telefono as telefono_apoderado', 'apoderados.nombre as nombre_apoderado', 'notas.id as idnotas', 'notas.semestre',  'notas.idasignatura', 'asignaturas.nombre as nombreasignatura'
                ,'notas.nota1','notas.nota2','notas.nota3','notas.nota4','notas.nota5','notas.nota6','notas.nota7','notas.nota8','notas.nota9','notas.nota10','notas.nota11','notas.nota12')
                ->where('alumnos.idcurso', '=', $idcurso)
                ->where('notas.idasignatura', '=', $idasignatura)
                ->where('notas.semestre', '=', $semestre)
                ->where('alumnos.'.$criterio , 'like' , '%' . $buscar . '%')
                ->orderBy('alumnos.id', 'desc')->paginate(6);        
            }

            return [
                'pagination' => [
                    'total'         => $alumnos->total(),
                    'current_page'  => $alumnos->currentPage(),
                    'per_page'      => $alumnos->perPage(),
                    'last_page'     => $alumnos->lastPage(),
                    'from'          => $alumnos->firstItem(),
                    'to'            => $alumnos->lastItem(),
                ],
                'alumnos' => $alumnos
            ];
    }

    public function selectAlumno(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $alumnos = Alumno::select('id', 'rut','nombre', 'condicion')
        ->where('condicion', '=', '1')
        ->Where('nombre', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['alumnos' => $alumnos];
    }
}
