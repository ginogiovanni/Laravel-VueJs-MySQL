<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;

class RegionController extends Controller
{
    public function selectRegion(Request $request){
        if(!$request->ajax()) return redirect('/');

        $regiones = Region::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return ['regiones' => $regiones];
    }
}
