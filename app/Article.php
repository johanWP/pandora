<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
        'name',
        'serializable',
        'barcode',
        'active',
        'company_id'
    ];

    /**
     * Un Articulo pertenece a una (y solo una) empresa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
