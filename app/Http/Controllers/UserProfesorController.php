<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UsuarioProfesor;
use App\User;
use App\Profesor;


class UserProfesorController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $profesores = UsuarioProfesor::join('profesores','usuariosprofesor.idprofesor','=','profesores.id')
            ->join('users', 'usuariosprofesor.iduser', '=', 'users.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('profesores.nombre', 'profesores.rut', 'usuariosprofesor.id', 'usuariosprofesor.idprofesor',
             'usuariosprofesor.iduser', 'users.usuario', 'users.password', 'users.idrol', 'users.condicion', 
             'roles.nombre as nombrerol', 'roles.descripcion')
            ->orderBy('usuariosprofesor.id', 'desc')
            ->paginate(6);
        }else{
            $profesores = UsuarioProfesor::join('profesores','usuariosprofesor.idprofesor','=','profesores.id')
            ->join('users', 'usuariosprofesor.iduser', '=', 'users.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('profesores.nombre', 'profesores.rut', 'usuariosprofesor.id', 'usuariosprofesor.idprofesor',
             'usuariosprofesor.iduser', 'users.usuario', 'users.password', 'users.idrol', 'users.condicion',
             'roles.nombre as nombrerol', 'roles.descripcion')
            ->where('profesores.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('usuariosprofesor.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $profesores->total(),
                'current_page'  => $profesores->currentPage(),
                'per_page'      => $profesores->perPage(),
                'last_page'     => $profesores->lastPage(),
                'from'          => $profesores->firstItem(),
                'to'            => $profesores->lastItem(),
            ],
            'profesores' => $profesores
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

            $usuarioprofesor = new UsuarioProfesor();
            $usuarioprofesor->idprofesor = $request->idprofesor;
            $usuarioprofesor->iduser = $user->id;
            $usuarioprofesor->save();

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
