<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    public $table = "apoderados";
    protected $fillable = ['rut', 'nombre', 'fecha_nac', 'edad', 'direccion', 'idcomuna', 'telefono', 'correo', 'condicion' ];

    public function comuna()
    {
        return $this->belongsTo('App\Comuna');
    }

    public function alumnos()
    {
        return $this->hasMany('App\Alumno');
    }
    
    public function comunicacionesapoderados()
    {
        return $this->hasMany('App\ComunicacionApoderado');
    }

    public function users(){
    	return $this->belongsToMany('\App\User','usuariosapoderados'); 
    } 
}
