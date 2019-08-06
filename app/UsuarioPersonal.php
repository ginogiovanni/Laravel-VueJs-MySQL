<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPersonal extends Model
{
    protected $table = 'usuariospersonal';
    protected $fillable = ['id', 'idpersonal', 'iduser'];
    public $timestamps = false;

    public function users(){
        return $this->hasMany('App\User');
    }

    public function apoderados(){
        return $this->hasMany('App\Apoderado');
    }

}
