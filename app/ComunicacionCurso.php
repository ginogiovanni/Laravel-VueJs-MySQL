<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComunicacionCurso extends Model
{
    public $table = "comunicacionescursos";
    protected $fillable = ['titulo', 'mensaje', 'estado','idcurso', 'idprofesor'];

    public function curso()
    {
        return $this->belongsTo('App\Curso');
    }

    public function profesor()
    {
        return $this->belongsTo('App\Profesor');
    }
}
