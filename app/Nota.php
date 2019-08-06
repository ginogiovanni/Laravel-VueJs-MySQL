<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    public $table = "notas";
    protected $fillable = ['nota1', 'nota2', 'nota3', 'nota4', 'nota5'
    , 'nota6', 'nota7', 'nota8', 'nota9', 'nota10', 'nota11', 'nota12'
    , 'semestre','condicion','idasignatura', 'idalumno'];

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    public function alumno()
    {
        return $this->belongsTo('App\Alumno');
    }
}
