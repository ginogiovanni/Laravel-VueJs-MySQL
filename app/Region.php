<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $table = "regiones";
    protected $fillable = ['nombre', 'nombre_ordinal'];

    public function provincias()
    {
        return $this->hasMany('App\Provincia');
    }
}
