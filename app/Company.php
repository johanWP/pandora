<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'name',
        'parent'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Devuelve los usuarios de la empresa
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Establece la relación "una compañía tiene varios warehouses"
     * @return HasMany
     */
    public function warehouses()
    {
        return $this->hasMany('App\Warehouse');
    }


}

