<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    public $table = "profesores";
    protected $fillable = ['rut', 'nombre', 'fecha_nac', 'edad', 'direccion', 'idcomuna', 'telefono', 'correo', 'condicion' ];

    public function comuna()
    {
        return $this->belongsTo('App\Comuna');
    }

    public function asignaturasprofesores()
    {
        return $this->hasMany('App\AsignaturaProfesor');
    }

    public function usuariopersonal()
    {
        return $this->belongsTo('App\UsuarioPersonal');
    }

    public function comunicacionesapoderados()
    {
        return $this->hasMany('App\ComunicacionApoderado');
    }

    public function comunicacionescursos()
    {
        return $this->hasMany('App\ComunicacionCurso');
    }
}
