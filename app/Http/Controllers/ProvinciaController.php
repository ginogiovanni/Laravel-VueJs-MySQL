<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;

class ProvinciaController extends Controller
{
    public function selectProvincia(Request $request){
        if(!$request->ajax()) return redirect('/');

        $region = $request->region;

        $provincias = Provincia::where('idregion', '=', $region)->select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return ['provincias' => $provincias];
    }
}
