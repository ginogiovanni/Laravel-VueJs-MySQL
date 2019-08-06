<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $fillable = ['nombre', 'idprovincia'];

    public function provincia()
    {
        return $this->belongsTo('App\Provincia');
    }

    public function personals()
    {
        return $this->hasMany('App\Personal');
    }

    public function profesores()
    {
        return $this->hasMany('App\Profesor');
    }

    public function apoderados()
    {
        return $this->hasMany('App\Profesor');
    }

    public function alumnos()
    {
        return $this->hasMany('App\Alumno');
    }
}
