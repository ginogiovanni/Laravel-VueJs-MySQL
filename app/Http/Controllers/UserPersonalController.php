<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UsuarioPersonal;
use App\User;
use App\Personal;

class UserPersonalController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $personals = UsuarioPersonal::join('personals','usuariospersonal.idpersonal','=','personals.id')
            ->join('users', 'usuariospersonal.iduser', '=', 'users.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('personals.nombre', 'personals.rut', 'usuariospersonal.id', 'usuariospersonal.idpersonal',
             'usuariospersonal.iduser', 'users.usuario', 'users.password', 'users.idrol', 'users.condicion', 
             'roles.nombre as nombrerol', 'roles.descripcion')
            ->orderBy('usuariospersonal.id', 'desc')
            ->paginate(6);
        }else{
            $personals = UsuarioPersonal::join('personals','usuariospersonal.idpersonal','=','personals.id')
            ->join('users', 'usuariospersonal.iduser', '=', 'users.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('personals.nombre', 'personals.rut', 'usuariospersonal.id', 'usuariospersonal.idpersonal',
             'usuariospersonal.iduser', 'users.usuario', 'users.password', 'users.idrol', 'users.condicion',
             'roles.nombre as nombrerol', 'roles.descripcion')
            ->where('personals.'.$criterio , 'like' , '%' . $buscar . '%')
            ->orderBy('usuariospersonal.id', 'desc')
            ->paginate(6);
        }

        return [
            'pagination' => [
                'total'         => $personals->total(),
                'current_page'  => $personals->currentPage(),
                'per_page'      => $personals->perPage(),
                'last_page'     => $personals->lastPage(),
                'from'          => $personals->firstItem(),
                'to'            => $personals->lastItem(),
            ],
            'personals' => $personals
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

            $usuariopersonal = new UsuarioPersonal();
            $usuariopersonal->idpersonal = $request->idpersonal;
            $usuariopersonal->iduser = $user->id;
            $usuariopersonal->save();

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
