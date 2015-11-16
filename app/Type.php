<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Type extends Model
{
    use SoftDeletes;
    // Estos son los campos que se pueden llenar desde el formulario

    protected $fillable=[
        'name'
    ];

    /**
     * Establece la relación "un tipo puede tener varios almacenes"
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouses()
    {

        return $this->hasMany('App\Warehouse');
    }
}
