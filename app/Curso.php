<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'jornada', 'condicion'];

    public function alumnos()
    {
        return $this->hasMany('App\Alumno');
    }

    public function asignaturasprofesores()
    {
        return $this->hasMany('App\AsignaturaProfesor');
    }

    public function comunicacionescursos()
    {
        return $this->hasMany('App\ComunicacionCurso');
    }
}
