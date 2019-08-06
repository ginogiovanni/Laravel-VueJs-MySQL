<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    //protected $table = 'asignaturas';
    //protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'condicion'];

    public function asignaturasprofesores()
    {
        return $this->hasMany('App\AsignaturaProfesor');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }
}
