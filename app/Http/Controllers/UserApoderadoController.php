<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\UsuarioApoderado;
use App\User;
use App\Apoderado;

class UserApoderadoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $apoderados = UsuarioApoderado::join('apoderados','usuariosapoderados.idapoderado','=','apoderados.id')
            ->join('users', 'usuariosapoderados.iduser', '=', 'users.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('apoderados.nombre', 'apoderados.rut', 'usuariosapoderados.id', 'usuariosapoderados.idapoderado',
             'usuariosapoderados.iduser', 'users.usuario', 'users.password', 'users.idrol', 'users.condicion', 
             'roles.nombre as nombrerol', 'roles.descripcion')
            ->orderBy('usuariosapoderados.id', 'desc')
            ->paginate(6);
        }else{
            $apoderados = UsuarioApoderado::join('apoderados','usuariosapoderados.idapoderado','=','apoderados.id')
            ->join('users', 'usuariosapoderados.iduser', '=', 'users.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('apoderados.nombre', 'apoderados.rut', 'usuariosapoderados.id', 'usuariosapoderados.idapoderado',
             'usuariosapoderados.iduser', 'users.usuario', 'users.password', 'users.idrol', 'users.condicion',
             'roles.nombre as nombrerol', 'roles.descripcion')
            ->where('apoderados.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('usuariosapoderados.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $apoderados->total(),
                'current_page'  => $apoderados->currentPage(),
                'per_page'      => $apoderados->perPage(),
                'last_page'     => $apoderados->lastPage(),
                'from'          => $apoderados->firstItem(),
                'to'            => $apoderados->lastItem(),
            ],
            'apoderados' => $apoderados
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password );
            $user->idrol = $request->idrol;
            $user->condicion = '1';
            $user->save();

            $usuarioapoderado = new UsuarioApoderado();
            $usuarioapoderado->idapoderado = $request->idapoderado;
            $usuarioapoderado->iduser = $user->id;
            $usuarioapoderado->save();

            DB::commit();

        }catch (Exception $e){
            DB::rollback();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->usuario = $request->usuario;
        $user->password = bcrypt( $request->password );
        $user->idrol = $request->idrol;
        $user->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
