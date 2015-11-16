<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
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
     * Establece la relación "una compañía tiene varios warehouses"
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouses()
    {

        return $this->hasMany('App\Warehouse');
    }


}

