<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    // Estos son los campos que se pueden llenar desde el formulario

    protected $fillable=[
        'name'
    ];
}
