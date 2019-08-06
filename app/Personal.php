<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $fillable = ['rut', 'nombre', 'fecha_nac', 'edad', 'direccion', 'idcomuna', 'condicion', 'telefono', 'correo' ];

    public function comuna()
    {
        return $this->belongsTo('App\Comuna');
    }

    public function usuariopersonal()
    {
        return $this->belongsTo('App\UsuarioPersonal');
    }

    public function eventos()
    {
        return $this->hasMany('App\Evento');
    }
}
