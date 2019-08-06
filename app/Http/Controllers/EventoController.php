<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use Auth;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $eventos = Evento::join('personals', 'eventos.idpersonal', '=', 'personals.id')
            ->select('eventos.id','eventos.titulo', 'eventos.mensaje', 'eventos.estado', 'eventos.idpersonal', 'personals.nombre', 'personals.rut')
            ->orderBy('eventos.id','desc')->paginate(5);
        }else{
            $eventos = Evento::join('personals', 'eventos.idpersonal', '=', 'personals.id')
            ->select('eventos.id', 'eventos.titulo', 'eventos.mensaje', 'eventos.estado', 'eventos.idpersonal', 'personals.nombre', 'personals.rut')
            ->where('personals.'.$criterio, 'like', '%' . $buscar . '%')
            ->orderBy('eventos.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         => $eventos->total(),
                'current_page'  => $eventos->currentPage(),
                'per_page'      => $eventos->perPage(),
                'last_page'     => $eventos->lastPage(),
                'from'          => $eventos->firstItem(),
                'to'            => $eventos->lastItem(),
            ],
            'eventos' => $eventos
        ];
    }

    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $eventos = new Evento();
        $eventos->titulo = $request->titulo;
        $eventos->mensaje = $request->mensaje;
        $eventos->idpersonal = $request->idpersonal;
        $eventos->estado = '1';
        $eventos->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $eventos = Evento::findOrFail($request->id);
        $eventos->titulo = $request->titulo;
        $eventos->mensaje = $request->mensaje;
        $eventos->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $eventos = Evento::findOrFail($request->id);
        $eventos->estado = '0';
        $eventos->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $eventos = Evento::findOrFail($request->id);
        $eventos->estado = '1';
        $eventos->save();
    }

    public function getEventos(){
        $eventos = Evento::join('personals', 'eventos.idpersonal', '=', 'personals.id')
        ->select('eventos.id', 'eventos.titulo', 'eventos.mensaje', 'eventos.created_at', 'personals.nombre')
        ->orderBy('eventos.id', 'desc')->get();

        return $eventos;
    }


}
