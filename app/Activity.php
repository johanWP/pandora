<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    // Los campos que se pueden llenar a través de un formulario expuesto en el sitio
    protected $fillable = [
            'name'
    ];

    /**
     * Devuelve las empresas que realizan una actividad
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany('App\Company')->withTimestamps();
    }

}
