<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComunicacionApoderado extends Model
{
    public $table = "comunicacionesapoderados";
    protected $fillable = ['titulo', 'mensaje', 'leido', 'estado','idapoderado', 'idprofesor'];

    public function apoderado()
    {
        return $this->belongsTo('App\Apoderado');
    }

    public function profesor()
    {
        return $this->belongsTo('App\Profesor');
    }
}
