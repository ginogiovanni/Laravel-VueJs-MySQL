<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Asignatura;

class AsignaturaController extends Controller
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
            $asignaturas = Asignatura::orderBy('id','desc')->paginate(6);
        }else{
            $asignaturas = Asignatura::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         => $asignaturas->total(),
                'current_page'  => $asignaturas->currentPage(),
                'per_page'      => $asignaturas->perPage(),
                'last_page'     => $asignaturas->lastPage(),
                'from'          => $asignaturas->firstItem(),
                'to'            => $asignaturas->lastItem(),
            ],
            'asignaturas' => $asignaturas
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
        $asignatura = new Asignatura();
        $asignatura->nombre = $request->nombre;
        $asignatura->condicion = '1';
        $asignatura->save();
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
        $asignatura = Asignatura::findOrFail($request->id);
        $asignatura->nombre = $request->nombre;
        $asignatura->condicion = '1';
        $asignatura->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $asignatura = Asignatura::findOrFail($request->id);
        $asignatura->condicion = '0';
        $asignatura->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $asignatura = Asignatura::findOrFail($request->id);
        $asignatura->condicion = '1';
        $asignatura->save();
    }

    public function selectAsignatura(Request $request){
        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $asignaturas = Asignatura::select('id', 'nombre')
        ->where('condicion', '=', '1')
        ->Where('nombre', 'like', '%'. $filtro . '%')
        ->orderBy('nombre', 'asc')->get();

        return ['asignaturas' => $asignaturas];
    }

}
