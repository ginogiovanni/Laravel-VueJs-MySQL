<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignaturaProfesor extends Model
{
    public $table = "asignaturasprofesores";
    protected $fillable = ['idprofesor', 'idasignatura', 'idcurso', 'dia', 'hora_inicio', 'hora_fin', 'semestre', 'jefe', 'condicion' ];

    public function profesor()
    {
        return $this->belongsTo('App\Profesor');
    }

    public function curso()
    {
        return $this->belongsTo('App\Curso');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    
}
