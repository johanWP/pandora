<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class Activity extends Model
{
    use SoftDeletes;
    // Los campos que se pueden llenar a través de un formulario expuesto en el sitio
    protected $fillable = [
            'name'
    ];

    protected $dates = ['deleted_at'];
    /**
     * Devuelve las empresas que realizan una actividad
     * @return BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany('App\Company')->withTimestamps();
    }

    /**
     * Obtener los usuarios que realizan la actividad
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * Establece la relación "una actividad la hacen varios almacenes"
     * @return HasMany
     */
    public function warehouses()
    {

        return $this->hasMany('App\Warehouse');
    }
}
