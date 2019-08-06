<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    public $table = "alumnos";
    protected $fillable = ['rut', 'nombre', 'fecha_nac', 'edad', 'direccion', 'idcomuna', 'idcurso', 'idapoderado', 'condicion' ];

    public function comuna()
    {
        return $this->belongsTo('App\Comuna');
    }

    public function curso()
    {
        return $this->belongsTo('App\Curso');
    }

    public function apoderado()
    {
        return $this->belongsTo('App\Apoderado');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }
}
