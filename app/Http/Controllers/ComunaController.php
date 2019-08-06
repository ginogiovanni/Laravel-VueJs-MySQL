<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comuna;

class ComunaController extends Controller
{
    public function selectComuna(Request $request){
        if(!$request->ajax()) return redirect('/');

        $provincia = $request->provincia;

        $comunas = Comuna::where('idprovincia', '=', $provincia)->select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return ['comunas' => $comunas];
    }
}
