<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = ['nombre', 'idregion'];

    public function comunas()
    {
        return $this->hasMany('App\Comuna');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }
}
