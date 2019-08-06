<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $roles = Rol::orderBy('id','desc')->paginate(6);
        }else{
            $roles = Rol::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         => $roles->total(),
                'current_page'  => $roles->currentPage(),
                'per_page'      => $roles->perPage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem(),
            ],
            'roles' => $roles
        ];
    }
    
    public function selectRol(Request $request){
        if(!$request->ajax()) return redirect('/');

        $roles = Rol::select('id', 'nombre', 'descripcion')->orderBy('nombre', 'asc')->get();

        return ['roles' => $roles];
    }
    
}
