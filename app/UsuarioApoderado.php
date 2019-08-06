<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioApoderado extends Model
{
    protected $table = 'usuariosapoderados';
    protected $fillable = ['id', 'idapoderado', 'iduser'];
    public $timestamps = false;

    public function users(){
        return $this->hasMany('App\User');
    }

    public function apoderados(){
        return $this->hasMany('App\Apoderado');
    }


}
