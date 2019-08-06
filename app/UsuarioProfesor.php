<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioProfesor extends Model
{
    protected $table = 'usuariosprofesor';
    protected $fillable = ['id', 'idprofesor', 'iduser'];
    public $timestamps = false;

    public function users(){
        return $this->hasMany('App\User');
    }

    public function profesores(){
        return $this->hasMany('App\Profesor');
    }
}
