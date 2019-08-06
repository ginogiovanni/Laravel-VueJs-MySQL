<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Curso;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $cursos = Curso::orderBy('id','desc')->paginate(5);
        }else{
            $cursos = Curso::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         => $cursos->total(),
                'current_page'  => $cursos->currentPage(),
                'per_page'      => $cursos->perPage(),
                'last_page'     => $cursos->lastPage(),
                'from'          => $cursos->firstItem(),
                'to'            => $cursos->lastItem(),
            ],
            'cursos' => $cursos
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $curso = new Curso();
        $curso->nombre = $request->nombre;
        $curso->descripcion = $request->descripcion;
        $curso->jornada = $request->jornada;
        $curso->condicion = '1';
        $curso->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $curso = Curso::findOrFail($request->id);
        $curso->nombre = $request->nombre;
        $curso->descripcion = $request->descripcion;
        $curso->jornada = $request->jornada;
        $curso->condicion = '1';
        $curso->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $curso = Curso::findOrFail($request->id);
        $curso->condicion = '0';
        $curso->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $curso = Curso::findOrFail($request->id);
        $curso->condicion = '1';
        $curso->save();
    }

    public function selectCurso(Request $request){
        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $cursos = Curso::select(DB::raw('CONCAT(nombre, " ", descripcion) AS cursocom'), 'id', 'nombre', 'descripcion', 'jornada' )
        ->where('condicion', '=', '1')
        ->Where('nombre', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['cursos' => $cursos];
    }
}