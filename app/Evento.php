<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    public $table = "eventos";
    protected $fillable = ['titulo', 'mensaje', 'estado','idpersonal'];

    public function personal()
    {
        return $this->belongsTo('App\Personal');
    }
    
}
