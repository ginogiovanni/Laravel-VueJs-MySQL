<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nota;

class NotaController extends Controller
{
    public function getNotas($idapod){
        $notas = Nota::join('asignaturas','notas.idasignatura','=','asignaturas.id')
            ->join('alumnos', 'notas.idalumno', '=', 'alumnos.id')
            ->join('apoderados', 'alumnos.idapoderado', '=', 'apoderados.id')
            ->join('usuariosapoderados','apoderados.id','=','usuariosapoderados.idapoderado')
            ->select('notas.nota1', 'notas.nota2', 'notas.nota3', 'notas.nota4', 'notas.nota5', 'notas.nota6', 'notas.nota7', 'notas.nota8'
            , 'notas.nota9', 'notas.nota10', 'notas.nota11', 'notas.nota12', 'asignaturas.nombre')
            ->where('usuariosapoderados.iduser',  '=', $idapod)
            ->orderBy('notas.id', 'desc')->get();

        return $notas;
    }

    public function getNotasReport(Request $request){

        $buscar = $request->buscar;

        $notas = Nota::join('asignaturas','notas.idasignatura','=','asignaturas.id')
            ->join('alumnos', 'notas.idalumno', '=', 'alumnos.id')
            ->join('apoderados', 'alumnos.idapoderado', '=', 'apoderados.id')
            ->select('notas.nota1', 'notas.nota2', 'notas.nota3', 'notas.nota4', 'notas.nota5', 'notas.nota6', 'notas.nota7', 'notas.nota8'
            , 'notas.nota9', 'notas.nota10', 'notas.nota11', 'notas.nota12', 'asignaturas.nombre as nombreasignatura', 'alumnos.rut', 'alumnos.nombre', 'alumnos.id')
            ->where('alumnos.id',  '=', $buscar)
            ->orderBy('notas.id', 'desc')->paginate(6);

            return [
                'pagination' => [
                    'total'         => $notas->total(),
                    'current_page'  => $notas->currentPage(),
                    'per_page'      => $notas->perPage(),
                    'last_page'     => $notas->lastPage(),
                    'from'          => $notas->firstItem(),
                    'to'            => $notas->lastItem(),
                ],
                'notas' => $notas
            ];

    }
    
}
