<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;
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
