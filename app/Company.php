<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $fillable=[
        'name',
        'parent'
    ];

    /**
     * Devuelve los articulos creados por usuarios de esta empresa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Article');

    }

    /**
     * Devuelve los usuarios de la empresa
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Devuelve las actividades que realiza una empresa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activities()
    {
        return $this->belongsToMany('App\Activity')->withTimestamps();
    }

    /**
     * Devuelve una lista de los IDs de las actividades que realiza esta empresa
     * @return array
     */
    public function getActivityListAttribute()
    {

        return $this->activities()->lists('id');
    }

}

